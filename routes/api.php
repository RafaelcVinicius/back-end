<?php

use App\Http\Controllers\ConsultaDadosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('/')->group(function (){
    Route::post('/login',               [LoginController::class,         'login'        ]);
    Route::post('/register',            [LoginController::class,         'register'     ]);
    Route::post('/{id}/edit',           [LoginController::class,         'edit'         ]);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/consulta')->group(function (){
        Route::get('/',        function(){ return json_encode('ola');});
        Route::get('/dados',            [ConsultaDadosController::class, 'consultaDados']);
    });

    Route::prefix('/bcb')->group(function (){
        Route::get('/',            [ConsultaDadosController::class, 'showApiBcbSgs']);
    });

});