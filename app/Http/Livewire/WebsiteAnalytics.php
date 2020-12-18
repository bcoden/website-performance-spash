<?php

namespace App\Http\Livewire;

use App\Models\Score;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class WebsiteAnalytics extends Component
{
    const COLOR_GREEN = 1;
    const COLOR_ORANGE = 2;
    const COLOR_RED = 3;

    private $colors = [
        self::COLOR_GREEN => 'green',
        self::COLOR_ORANGE => 'orange',
        self::COLOR_RED => 'red'
    ];

    public $website;
    public $stats;
    public $overall;
    public $color;

    protected $rules = [
        'website' => 'url',
    ];

    protected $messages = [
        'website.url' => 'Invalid Url.'
    ];

    public function updatedWebsite(): void {
        $this->resetState();
        $this->website = $this->addScheme($this->website);
        $this->validate();

        // check cache for existing record
        $key = md5($this->website);
        if (Cache::has($key)) {
            $this->stats = Cache::get($key);
            $this->overall = $this->getOverallStat();
            return;
        }

        // runs lighthouse commands
        $process = $this->getStats();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            // set error
            $errors = $this->getErrorBag();
            $errors->add('website', trans('Failed to get website, please try again'));
            $this->reset('stats');
            return;
        }

        // send stats to browser
        $payload = $process->getOutput();
        $this->stats = $this->calculateScores($payload);
        $this->overall = $this->getOverallStat();

        // add to cache
        Cache::put($key, $this->stats, 60 * 60 * 24 * 7); // cache for one week

        // store in db
        $score = Score::where('url', $this->website)->first();
        if (!$score) {
            (new Score([
                'url' => $this->website,
                'payload' => $payload
            ]))->save();
        } else {
            $score->payload = $payload;
            $score->save();
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.website-analytics');
    }

    /**
     * @param $url
     * @param string $scheme
     * @return string
     */
    private function addScheme($url, $scheme = 'https://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }

    /**
     * @param $stats
     * @return array
     */
    private function calculateScores($stats): array {
        $scores = [];
        $stats = json_decode($stats, true);
        if (!$stats) {
            return $scores;
        }

        $categories = $stats['categories'] ?? null;
        if (!$categories) {
            return $scores;
        }

        $keys = array_keys($categories);
        $scores = array_combine(
            $keys,
            array_map(function($v, $key) {
                $score = $v['score'] ?? null;
                if (!$score) {
                    $score = 0;
                }

                return $score*100;
            }, $categories, $keys)
        );

        return $scores;
    }

    private function resetState(): void
    {
        $this->resetErrorBag();
        $this->reset('stats');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function getStats()
    {
        $process = app('App\Process', [
            'lighthouse',
            escapeshellcmd($this->website),
            '--output=json',
            '--quiet',
            '--chrome-flags="--headless"'
        ]);

        // run the process
        $process->run(NULL, [
            'PATH' => '/usr/bin:/usr/local/bin/'
        ]);

        return $process;
    }

    /**
     * @return float|int
     */
    private function getOverallStat()
    {
        return  round((array_reduce(array_values($this->stats), function ($carry, $now) {
            $carry += $now;
            return $carry;
        }) / count($this->stats)));
    }

    /**
     * @param int $percent
     * @return string
     */
    public function getColor(int $percent): string {
        $color = $this->colors[self::COLOR_RED];
        if ($percent > 80) {
            $color = $this->colors[self::COLOR_GREEN];
        } else if ($percent > 60) {
            $color = $this->colors[self::COLOR_ORANGE];
        }

        return $color;
    }
}
