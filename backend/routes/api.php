<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCertificateController;
use App\Http\Controllers\CertificateController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/user/register', [UserAuthController::class, 'register']); // done
Route::post('/user/login', [UserAuthController::class, 'login']); // done
Route::post('/admin/login', [AdminAuthController::class, 'login']); // done

Route::group(['prefix' => 'user', 'middleware' => ['auth:users', 'jwt.auth']], function () {
    Route::post('/logout', [UserAuthController::class, 'logout']); // done
    Route::get('/profile', [UserAuthController::class, 'profile']); // done
    Route::put('/update', [UserController::class, 'update']); // ID will be sent from the frontend // done
    Route::get('/certificates', [UserCertificateController::class, 'index']); // ID will be sent from the frontend // done
    Route::post('/certificates/add', [UserCertificateController::class, 'store']); // user_id and certificate_id will be sent from the frontend // done
    Route::delete('/certificates/delete', [UserCertificateController::class, 'destroy']); // ID will be sent from the frontend  // done
});

Route::group(['prefix' => 'users', 'middleware' => ['auth:admins', 'jwt.auth']], function () {
    Route::get('/', [UserController::class, 'index']); //done
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admins', 'jwt.auth']], function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']); //done
    Route::put('/user/approve', [UserController::class, 'approve']); // ID will be sent from the frontend // done

});

Route::group(['prefix' => 'certificates', 'middleware' => ['auth:admins', 'jwt.auth']], function () {
    Route::get('/get', [CertificateController::class, 'index']); //done
    Route::post('/add', [CertificateController::class, 'store']); //done
    Route::delete('/delete/{id}', [CertificateController::class, 'destroy']); //done
});

Route::group(['prefix' => 'certificates', 'middleware' => ['auth:users', 'jwt.auth']], function () {
    Route::get('/', [CertificateController::class, 'index']); //done
});