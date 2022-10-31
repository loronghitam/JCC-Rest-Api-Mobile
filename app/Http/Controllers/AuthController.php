<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use App\Http\Requests\RegistryRequest;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    use HttpResponses;

    public function register(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required',
                'email'     => 'required|email:filter|unique:users',
                'password'  => 'required|min:8',
                'role'  => 'required',
            ];

            $message = [
                'email.required'    => 'Mohon isikan email anda',
                'role.required'    => 'Mohon isikan role anda',
                'email.email'       => 'Mohon isikan email valid',
                'email.unique'      => 'Email sudah terdaftar',
                'password.required' => 'Mohon isikan password anda',
                'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }
            $data = DB::transaction(function () use ($request) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ])->userDetail()->create()->address()->create();
            });

            return apiResponse(200, 'success', 'Berhasil Registrasi', $data);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function login(Request $request)
    {
        try {
            // dd($request);
            $rules = [
                'email'     => 'required|email',
                'password'  => 'required|min:8',
            ];

            $message = [
                'email.required'    => 'Mohon isikan email anda',
                'email.email'       => 'Mohon isikan email valid',
                'password.required' => 'Mohon isikan password anda',
                'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ');
            }

            $data = [
                'email'     => $request->email,
                'password'  => $request->password,
            ];

            if (!Auth::attempt($data)) {
                return apiResponse(400, 'error', 'Data tidak terdaftar, akun bodong nya?');
            }

            $token = Auth::user()->createToken('API Token')->accessToken;
            $data   = [
                'token'     => $token,
                'role'     => auth()->user()->role,
                'user'      => Auth::user()->detail,
            ];

            return apiResponse(200, 'success', 'berhasil login', $data);
        } catch (Exception $e) {
            dd($e);
        }

        // return response()->json('login page');
        return 'Asik';
    }

    public function logout()
    {
        if (Auth::user()) {
            $tokens = Auth::user()->tokens->pluck('id');
            Token::whereIn('id', $tokens)->update([
                'revoked' => true
            ]);

            RefreshToken::whereIn('access_token_id', $tokens)->update([
                'revoked' => true
            ]);
        }

        return apiResponse(200, 'succes', 'berhasil logout');
    }
}
