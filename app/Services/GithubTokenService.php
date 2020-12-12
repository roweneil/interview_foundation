<?php

namespace App\Services;

use App\User;
use Github\Exception\RuntimeException;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Support\Facades\Crypt;

class GithubTokenService
{
    /**
     * Validate the token actually works.
     *
     * @return Boolean
     */
    public static function validate($token)
    {
        $github = new GithubConnection();
        $github->setToken($token);

        // todo: couldn't find an 'validation' method, so just see if returning watchers works
        try {
            $github->conn()->me()->watchers()->all();
        } catch(RuntimeException $e) {
            return false;
        }

        return true;
    }

    public static function updateUserToken(User $user, $token)
    {
        $user->github_token = Crypt::encrypt($token);
        $user->save();

        return $user;
    }
}
