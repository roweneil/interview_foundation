<?php

namespace App\Http\Controllers;

use App\Services\GithubTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateGithubTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = trim($request->token);
        $isValid = GithubTokenService::validate($token);

        if(!$isValid) {
            return response()->json([
                'error' => 'Unable to authenticate. Please check and try again.',
            ], 422);
        }

        $user = GithubTokenService::updateUserToken(Auth::user(), $token);

        return [
            'user' => $user
        ];
    }
}
