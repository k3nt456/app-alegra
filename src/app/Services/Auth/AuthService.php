<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use App\Traits\HasResponse;
use Illuminate\Support\Facades\DB;

class AuthService
{
    use HasResponse;

    public function register($params)
    {
        try {
            DB::beginTransaction();
            #Verificar duplicado de nombre o correo
            $validate = $this->checkDuplicate($params['name'], $params['email']);
            if (!$validate->original['status']) {
                session()->flash('error', $validate->original['data']['message']);
                return redirect()->back();
            }

            $user = $this->createUser($params);

            Auth::login($user);
            DB::commit();
            return redirect(route('kitchen'));
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Ocurrió un error, intente nuevamente.');
            return redirect()->back();
        }
    }

    private function createUser($user): User
    {
        $user = User::create([
            'username'  => $user['name'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'password'  => $this->hashPassword($user['password']),
            'encrypted_password' => $this->cryptPassword($user['password'])
        ]);
        return $user;
    }

    private function hashPassword($password)
    {
        return Hash::make($password);
    }

    private function cryptPassword($password)
    {
        return Crypt::encryptString($password);
    }

    private function checkDuplicate($name, $email)
    {
        $user = User::where('username', $name)->orWhere('email', $email)->first();
        if ($user) {
            if ($user->username == $name) {
                return $this->errorResponse('Intente con otro nombre de usuario.', 400);
            } elseif ($user->email == $email) {
                return $this->errorResponse('El correo ya esta en uso.', 400);
            }
        }

        return $this->successResponse('OK');
    }

    public function login($params)
    {
        try {
            # Verificar inicio de sesión
            if (Auth::check()) return redirect()->route('kitchen');

            $credentials = [
                'username' => $params['username'],
                'password' => $params['password'],
            ];

            if (Auth::attempt($credentials)) {
                request()->session()->regenerate();
                return redirect()->intended(route('kitchen'));
            }

            session()->flash('error', 'Usuario o contraseña inválido, intente nuevamente.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', 'Hubo un erro al iniciar sesión, intente nuevamente.');
            return redirect()->back();
        }
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('kitchen');
        }

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('login'));
    }
}
