<?php

namespace App\Services;

use Github\Exception\RuntimeException;
use GrahamCampbell\GitHub\Facades\GitHub;

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
}
