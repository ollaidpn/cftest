<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function quiz() {
        return $this->hasOne(Quiz::class);
    }

    public function sections() {
        return $this->hasMany(Section::class);
    }



}
