<?php

namespace App\Services;

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
    }

    public function conn()
    {
        return GitHub::getFactory()->make([
            'token' => $this->token,
            'method' => 'token',
        ]);
    }
}
