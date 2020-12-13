<?php

namespace App\Http\Controllers;

use App\Services\GithubConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetStarredReposController extends Controller
{
    public function __invoke()
    {
        $github = new GithubConnection();
        $github->setTokenFromUser(Auth::user());

        $repos = $github->fetchStarredRepos();

        return [
            'repos' => $repos,
        ];
    }
}
