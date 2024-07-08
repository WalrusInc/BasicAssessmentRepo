<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Login route




Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::get('/api/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::middleware('web')->group(function () {
    Route::post('/api/login', [AuthController::class, 'login']);
    
});
Route::post('/api/register', [AuthController::class, 'register']);





