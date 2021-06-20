<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetedSkill extends Model
{
    use HasFactory;

    public function formation() {
        return $this->belongsTo(Formation::class);
    }
}
