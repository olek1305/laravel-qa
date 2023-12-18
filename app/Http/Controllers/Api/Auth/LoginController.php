<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => '4',
            'client_secret' => 'S7ehoTtrUusPMw3PX4jx8LUlfaNi3gJdHi4qpov2',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $requestToken = Request::create(env('APP_URL') . '/oauth/token', 'post');
        $response = Route::dispatch($requestToken);

        return $response;
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You have been successfully logged out!'
        ]);
    }
}


