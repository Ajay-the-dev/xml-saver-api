<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TokenController extends Controller
{
    public function generate(Request $request)
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $token = $user->createToken('api-token')->plainTextToken;
        $response = [];
        $response['token'] = $token;
        $response['user'] = $user;
        return response()->json([
            "status" => 1,
            "message" => "Token generated",
            "data" => $response
        ]);

    }
}
