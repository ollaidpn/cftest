<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function students(){
        return $this->belongsToMany(User::class)->whereHas('role', function ($q)
                    {
                        $q->where('slug', 'student');
                    });
    }

    public function formations(){
        return $this->belongsToMany(Formation::class);
    }
}
