<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    **    logar e retornar um token
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('JWT');
            
            return response()->json($token->plainTextToken, 200);
        }

        return response()->json('Uauario invalido', 401);
    }

    /*
    **     registrar e chamar a função logar
    */
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name'     => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = new User();
        $user->name     = $credentials['name'];
        $user->email    = $credentials['email'];
        $user->password = bcrypt($credentials['password']);
        try {
            $user->save();
            $token = $user->createToken('JWT');

            return response()->json([
                'status'  => 'success',
                'message' => 'Dados gravados com sucesso',
                'token'   => $token->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Erro ao gravar os dados',
                'descricao' => 'error'.$th,
            ]);
        }
    }

    /*
    **  atualizar os registros
    */
    public function edit(Request $request, $id)
    {
        $credentials = $request->validate([
            'name'     => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::find($id);
        $user->name     = $credentials['name'];
        $user->email    = $credentials['email'];
        $user->password = bcrypt($credentials['password']);
        try {
            $user->save();
            $token = $user->createToken('JWT');

            return response()->json([
                'status'  => 'success',
                'message' => 'Dados gravados com sucesso',
                'token'   => $token->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Erro ao gravar os dados',
                'descricao' => 'error'.$th,
            ]);
        }
    }
}
