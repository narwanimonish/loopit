<?php

namespace App\Http\Controllers;

use App\Services\TokenService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->uncompromised(3),
            ],
            'name' => ['required'],
        ]);

        $user = $this->userService->registerUser($data);

        return $this->success(__('auth.registered'), $user, 201);
    }

    public function login(Request $request, TokenService $tokenService)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = $this->userService->getUser($data['email']);

        if (!$user || !$this->userService->validatePassword($user, $data)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $token = $tokenService->generateToken($user, 'web_app');

        return $this->success(__('auth.login'), [
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 200);
    }

    public function whoAmI(Request $request)
    {
        return Auth::user();
        return $this->success(__('auth.details'), Auth::user(), 200);
    }

    public function verifyLogin($id, $hash)
    {
        $user = $this->userService->getUserById($id);

        if ($user->hasVerifiedEmail()) {
            return $this->success(__('auth.already_validated'));
        }

        $this->userService->verifiyUser($user);

        return $this->success(__('auth.validated'));
    }

    public function resendVerification(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->success(__('auth.already_validated'));
        }

        $user->sendEmailVerificationNotification();

        return $this->success(__('auth.resend_validate'));
    }
}
