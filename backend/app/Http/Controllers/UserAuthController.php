<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Http\RedirectResponse;

class UserAuthController extends Controller
{



    public function login()
    {
        $login = request(['email', 'password']);

        $user = User::where('email', $login['email'])->first();

        if ($user)
            if (!$user['approved'])
                return response()->json(['error' => 'User is not yet approved'], 401);


        if (!$token = auth('users')->attempt($login))
            return response()->json(['error' => 'Invalid Email or Password'], 401);


        $user['last_login'] = date('d/m/Y h:i:s a', time());

        $user->save();



        return $this->createNewToken($token);

        // return response()->json(['User' => request(['email', 'password'])]);


    }

    public function register(AddUser $request)
    {


        $data = $request->all();

        $request->validated();

        $user = new User();

        $password = $request->password;

        $user->fill($data);

        $user->password = bcrypt($password);

        $user->save();


        return response()->json(['User' => $user]);
    }

    public function profile()
    {
        return response()->json(auth('users')->user());
    }

    public function logout()
    {
        auth('users')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function createNewToken($token)
    {
        $user = auth('users')->user();


        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}