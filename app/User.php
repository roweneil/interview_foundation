<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'github_token'
    ];

    /**
     * The attributes that should be included in model responses.
     *
     * @var array
     */
    protected $appends = [
        'actual_github_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Decrypted github token attribute.
     *
     * @return String
     */
    public function getActualGithubTokenAttribute()
    {
        if($this->github_token) {
            try {
                return Crypt::decrypt($this->github_token);
            } catch (DecryptException $e) {
                return null;
            }
        }
        return null;
    }
}
