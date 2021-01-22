<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponser;

    /**
     * Login user api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $requestData = $request->all();

        $validate = Validator::make($requestData, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return $this->errorResponse(__('Validation Error!'), (array)$validate->errors(), 422);
        }

        if (Auth::attempt($requestData)) {
            $user = Auth::user();

            $response = [
                'token' => $user->createToken(config('app.name'))->accessToken,
                'name' => $user->name,
            ];

            return $this->successResponse($response, __('User login successfully.'));
        } else {
            return $this->errorResponse(__('These credentials don\'t match our records.'));
        }
    }
}
