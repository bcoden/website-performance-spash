<?php

namespace Tests\Feature;

use App\Http\Livewire\WebsiteAnalytics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;

class WebsiteStatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function website_stats_component_is_on_the_homepage() {
        $this->get('/')->assertSeeLivewire('website-analytics');
    }

    /** @test */
    public function website_stats_component_does_not_work_with_no_input() {
        Livewire::test(WebsiteAnalytics::class)
            ->set('website', '')
            ->call('updatedWebsite')
            ->assertHasErrors(['website'=>'url']);
    }

    /** @test */
    public function website_stats_component_does_not_work_with_invalid_url() {
        $this->processMock(false);
        Livewire::test(WebsiteAnalytics::class)
            ->set('website', 'blahh')
            ->call('updatedWebsite')
            ->assertHasErrors(['website']);
    }

    /** @test */
    public function website_stats_component_works_with_valid_url() {
        $this->processMock(true, file_get_contents(__DIR__ . '/../data/lighthouse.json'));
        Livewire::test(WebsiteAnalytics::class)
            ->set('website', 'blahh')
            ->call('updatedWebsite')
            ->assertHasNoErrors()
            ->assertSet('stats', [
                "performance" => 0.4,
                "accessibility" => 0.91,
                "best-practices" => 0.8,
                "seo" => 0.79,
                "pwa" => 0.54
            ]);
    }

    private function processMock(bool $return = true, string $payload = '{}') {
        $process = Mockery::mock('Symfony\Component\Process\Process');
        $process->shouldReceive(
            'setTimeout',
            'run',
            'wait',
            'stop',
            'getCommandLine',
            'getExitCode',
            'getExitCodeText',
            'getWorkingDirectory',
            'isOutputDisabled',
            'getErrorOutput'
        );

        $process->shouldReceive('isSuccessful')->andReturn($return);
        $process->shouldReceive('getOutput')->andReturn($payload);

        // replace the instance of the Symfony Process with our mock
        $this->app->bind('App\Process', function ($app, $args) use ($process) {
            return $process;
        });

        return $process;
    }
}
