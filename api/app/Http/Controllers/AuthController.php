<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    /**
     * Register a new user.
     *
     * @param \App\Http\Requests\UserRequest $userRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $userRequest): JsonResponse
    {

        $user = User::create([
            'name' => $userRequest->name,
            'email' => $userRequest->email,
            'password' => bcrypt($userRequest->password),
            'organization_id' => $userRequest->organization_id,
        ]);

        if (!$user) {
            return $this->errorResponse('User registration failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->successResponse([
            'user' => $user->with('organization')->first(),
            'token' => $user->createToken('accessToken')->plainTextToken
        ], 'User registered successfully', Response::HTTP_CREATED);
    }

    /**
     * Login a user.
     *
     * @param \App\Http\Requests\UserRequest $userRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserRequest $userRequest): JsonResponse
    {
        $userRequest->setAction('login');
        $user = User::where('email', $userRequest->email)->with('organization')
            ->first();

        if (!Auth::attempt(['email' => $userRequest->email, 'password' => $userRequest->password])) {
            return $this->errorResponse('Invalid credentials!', Response::HTTP_NOT_FOUND, []);
        }

        return $this->successResponse([
            'token' => $user->createToken('accessToken')->plainTextToken,
            'user' => $user
        ], 'Logged in successfully', Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if (!$request->user()) {
            return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        // Revoke the token that was used to authenticate the user
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logged out successfully', Response::HTTP_OK);
    }
}
