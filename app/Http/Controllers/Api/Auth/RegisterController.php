<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use ApiResponser;

    /**
     * User register api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $requestData = $request->all();

        $validate = Validator::make($requestData, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        if ($validate->fails()) {
            return $this->errorResponse(__('Validation Error!'), $validate->errors(), 422);
        }

        $requestData['password'] = Hash::make($requestData['password']);

        $user = User::create($requestData);
        if (!$user) {
            return $this->errorResponse(__('User registration could\'t be created!'), [], 400);
        }

        $response = [
            'token' => $user->createToken(config('app.name'))->accessToken,
            'name' => $user->name,
        ];

        return $this->successResponse($response, __('User register successfully.'), 201);
    }
}
