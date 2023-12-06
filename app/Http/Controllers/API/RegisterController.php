<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends BaseController
{

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'level' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully');
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required',
        'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->sendError('Validation Eror.', 'The provided credentials are incorrect');
        }

        $success['token'] = $user->createToken($request->device_name)->plainTextToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, "User berhasil Login");




        // if (Auth::attempt(['username'=> $request->username, 'password' => $request->password])) {
        //     $user = Auth::user();
        //     $success['token'] = $user->createToken('MyApp')->plainTextToken;
        //     $success['name'] = $user->name;

        //     return $this->sendResponse($success, 'User login successfully');
        // } else {
        //     return $this->sendError('Unauthorized', ['error' => 'Unauthorized']);
        // }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
