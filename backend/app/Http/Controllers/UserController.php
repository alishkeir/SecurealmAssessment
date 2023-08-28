<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\AddUser;
use App\Http\Requests\User\UpdateUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        return User::all();
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $request)
    {
        $data = $request->all();

        $request->validated();

        $user = User::where('id', $request->id)->first();


        if ($data['name']) {
            $user->name = $data['name'];
        }

        if ($data['sex']) {
            $user->sex = $data['sex'];
        }

        if ($data['blood_type']) {
            $user->blood_type = $data['blood_type'];
        }

        $user->update($data);

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }


        $user->save();
        return response()->json(['User' => $data]);

    }


    public function approve(Request $request)
    {

        $data = $request->all();

        $user = User::where('id', $request->id)->first();

        $user->update($data);

        $user->approved = $request->approved || false;

        $user->save();

        return response()->json(['User' => $user]);

    }


}