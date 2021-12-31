<?php

namespace App\Http\Controllers;

use App\Models\EventUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()];
        }

        if (User::query()->where('email', $request->email)->exists()) {
            return ['success' => false, 'message' => 'Email sudah terdaftar, mohon gunakan email yang lain'];
        }

        if (!Role::query()->find($request->role_id)) {
            return ['success' => false, 'message' => 'Role not found'];
        }

        $token = sha1(time());

        $user = User::query()->create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'api_token' => $token
        ]);

        return ['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $user];
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()];
        }

        $user = User::query()->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['success' => false, 'message' => 'Maaf, password / email ada kesalahan'];
        }

        $user->api_token = sha1(time());

        $user->save();

        return ['success' => true, 'message' => 'Login berhasil', 'data' => $user];
    }

    public function events($id)
    {
        $result = EventUser::query()->where('user_id', $id)->with('events')->get();

        return ['data' => $result, 'total' => count($result)];
    }
}
