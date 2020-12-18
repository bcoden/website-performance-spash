<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'url',
        'payload'
    ];

    use HasFactory;

    public function inqueries() {
        return $this->hasMany(Inquiry::class, 'score_id');
    }
}
