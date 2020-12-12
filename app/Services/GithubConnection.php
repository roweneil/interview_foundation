<?php

namespace App\Services;

use App\User;
use Exception;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class GithubConnection
{
    private $token;

    public function __construct($token = null)
    {
        if($token) {
            $this->setToken($token);
        }
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function setTokenFromUser(User $user)
    {
        if($user && $user->actual_github_token) {
            $this->token = $user->actual_github_token;
        } else {
            throw new Exception("Failed to decrypt token.");
        }
        return $this;
    }

    public function conn()
    {
        return GitHub::getFactory()->make([
            'token' => $this->token,
            'method' => 'token',
        ]);
    }

    public function fetchStarredRepos()
    {
        return $this->conn()->me()->starring()->all();
    }
}
