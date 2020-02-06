<?php

namespace App\Http\Controllers\API;

use Auth;
use JWTAuth;
use App\Service\UserService;
use App\Http\Controllers\Controller;

/**
 * Class UserController
 *
 * @resource Users
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Website Admin auth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticateWebAdmin()
    {
        $webAdminUser = $this->userService->getUserByEmail(env('WEB_ADMIN_EMAIL'));

        $token = $webAdminUser->getJwtAccessToken();
        $authUser = null;

        // check if token in db
        if ($token) {
            $authUser = Auth::guard('user')->setToken($token)->user();
        }

        // check if token is valid
        if (!$authUser) {
            $token = Auth::guard('user')->login($webAdminUser);
        }

        $payload = Auth::guard('user')->payload();

        // check if token will expire in 30 seconds
        if ($payload('exp') < time() + 30) {
            $token = Auth::guard('user')->login($webAdminUser);
        }

        // save new token in db
        $webAdminUser->setJwtAccessToken($token);
        $this->userService->save($webAdminUser);

        return response()->json([
            'data' => compact('token'),
        ]);
    }
}
