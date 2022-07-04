<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;




class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'mobile',
        'profile_image',
        'active',
        'country_code',
        'business_account',
        'tax_id',
        'email_verified_at',
        'license'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'profile_image'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function subscribe_details()
    {
        return $this->hasOne(subscriber::class, 'user_id', 'id');
    }

    public function social_accounts()

    {

        return $this->hasOne('App\Models\SocialAccount', 'user_id');
    }
    public function allow()
    {
        return $this->hasOne(AllowLicense::class, 'user_id', 'id')->latest();
    }


    // public static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($user) { // before delete() method call this
    //         $user->subscribe_details()->delete();
    //         // do the rest of the cleanup...
    //     });
    // }



}
