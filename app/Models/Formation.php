<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Formation extends Model
{
    use HasFactory;

    public function categories() {
        return $this->belongsToMany(Categorie::class);
    }

    public function modules() {
        return $this->hasMany(Module::class);
    }

    public function enrollements(){
        return $this->hasMany(Enrollement::class);
    }

    public function goals() {
        return $this->hasMany(Goal::class);
    }

    public function requirements() {
        return $this->hasMany(Requirement::class);
    }

    public function targetedSkills() {
        return $this->hasMany(TargetedSkill::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->whereHas('role', function ($q)
        {
            $q->where('slug', 'teacher')->orWhere('slug', 'admin');
        })->withPivot('status', 'created_at', 'updated_at', 'process', 'actual_content_id', 'ended_contents', 'actual_content_type', 'suspended_quiz');
    }

    public function teacher() {
        return $this->users->first();
    }

    public function students() {
        return $this->belongsToMany(User::class)->whereHas('role', function ($q)
                    {
                        $q->where('slug', 'student');
                    })->withPivot('status', 'created_at', 'updated_at', 'actual_content_id', 'ended_contents');
    }

    public function teams(){
        return $this->belongsToMany(Team::class);
    }

    public function cover() {
        $image = str_replace('\\', '/', $this->image);

        $check_img = public_path('storage/'.$image);

        if(file_exists($check_img) && $this->image !== null)
            return asset('storage/'.$image);
        else
            return asset('assets/admin-formateurs/images/courses/t2.jpg');
    }

    public function getFormatedCreatedAt()
    {
        // dd($this->created_at->formatLocalized('%d de %B %Y'));
        setlocale(LC_TIME, "fr_FR");
        return strftime("%e %B %Y", strtotime($this->created_at));
    }

    public function getDidStartedAttribute()
    {
        $formation = Auth::user()->formations->where('id', $this->id)->first();
        return $formation ? true : false;
    }
}
