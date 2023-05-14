<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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




// Route::get('/login', function () {
//     return view('auth.login');
// });
// Route::get('/register', function () {
//     return view('auth.register');
// });

// Auth::routes();

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::group(
    ['middleware' => ['auth', 'revalidate']],
    function () {

        Route::get('/', function () {
            return view('dashboard');
        });

        Route::get('/profile', function () {
            return view('user.profile');
        });
        Route::put('/profile-update', [UserController::class, 'profile'])->name('profile.update');

        Route::group(
            ['middleware' => ['role:Admin']],
            function () {
                Route::resource('guru', GuruController::class);
                Route::resource('mapel', MapelController::class);
                Route::resource('kelas', KelasController::class);
                Route::resource('siswa', SiswaController::class);
                Route::resource('user', UserController::class);
                // Route::resource('ujian', UjianController::class);

                Route::put('/user/ban/{id}', [UserController::class, 'ban'])->name('user.ban');
            }
        );
        Route::group(
            ['middleware' => ['role:Guru|Admin']],
            function () {
                Route::resource('ujian', UjianController::class);
            }
        );
    }
);
