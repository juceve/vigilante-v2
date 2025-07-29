<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Intervention\Image\ImageManagerStatic as Image;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    static $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
    ];

    public function adminlte_desc()
    {
        $user = Auth::user();

        return $user->roles[0]->name;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'template',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function adminlte_image()
    {
        return "";
    }

    public function empleados()
    {
        return $this->hasMany('App\Models\Empleado', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registroguardias()
    {
        return $this->hasMany('App\Models\Registroguardia', 'user_id', 'id');
    }

    public function adminlte_profile_url()
    {
        return 'admin/profile';
    }
}
