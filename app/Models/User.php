<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function getOrganizationAttribute() {
        return count($this->teams) > 0 ? $this->teams[0]->organization : null;
    }
    public function enrollements(){
        return $this->hasMany(Enrollement::class);
    }

    public function formations() {
        return $this->belongsToMany(Formation::class)->withPivot('status', 'created_at', 'updated_at', 'process', 'actual_content_id', 'ended_contents', 'actual_content_type', 'suspended_quiz');
    }

    public function teams() {
        return $this->belongsToMany(Team::class)->with('organization');
    }

    public function testimonial() {
        return $this->hasOne(Testimonial::class);
    }

    public function getFullName() {
        if (!$this->first_name)
            $this->first_name = '';

        if (!$this->last_name)
            $this->last_name = '';

        return $this->first_name.' '.$this->last_name;
    }

    public function image() {
        $avatar = str_replace('\\', '/', $this->avatar);

        $check_img = public_path('storage/'.$avatar);

        if(file_exists($check_img) && $this->avatar !== null)
            return asset('storage/'.$avatar);
        else
            return asset('assets/admin-formateurs/images/avatar/avatar.png');
    }
}
