<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    public function quiz() {
        return $this->belongsTo(Quiz::class, 'quizze_id');
    }

    public function answers() {
        return $this->hasMany(QuizAnswer::class);
    }
}
