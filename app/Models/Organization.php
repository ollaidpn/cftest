<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    public function teams() {
        return $this->hasMany(Team::class);
    }

    public function image() {
        $logo = str_replace('\\', '/', $this->logo);

        $check_img = public_path('storage/'.$logo);

        if (file_exists($check_img) && $this->logo !== null)
            return asset('storage/'.$logo);
        else
            return "https://ui-avatars.com/api/?name=$this->name&rounded=true&background=0D8ABC&color=fff";
    }
}
