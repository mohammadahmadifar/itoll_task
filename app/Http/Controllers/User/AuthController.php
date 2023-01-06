<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\GetTokenRequest;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param GetTokenRequest $request
     * @return JsonResponse
     */
    public function getToken(GetTokenRequest $request): JsonResponse
    {
        if (!$user = User::whereUsername($request->get('username'))->first())
            return response()->json(['data' => ['type' => 'error', 'text' => __('messages.user_not_found')]]);

        return response()->json(['data' => [
            'type' => 'success', 'token_id' => $user->createToken('user')->plainTextToken,
        ]]);
    }
}
