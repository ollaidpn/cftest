<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    public function children() {
        return $this->hasMany(Categorie::class, 'category_parent', 'id');
    }

    public function parent() {
        return $this->belongsTo(Categorie::class, 'category_parent', 'id');
    }

    public function formations() {
        return $this->belongsToMany(Formation::class);
    }
}
