<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'phone',
        'email',
        'message',
        'score_id'
    ];

    public function score() {
        return $this->belongsTo(Score::class, 'score_id');
    }
}
