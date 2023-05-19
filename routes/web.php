<?php

use App\Http\Controllers\DetailUjianController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UjianSiswa;
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

        // Role only admin
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

        // Role admin and guru
        Route::group(
            ['middleware' => ['role:Guru|Admin']],
            function () {
                Route::resource('ujian', UjianController::class);
                Route::resource('detail-ujian', DetailUjianController::class);
                Route::get('detail-ujian/create/{id}', [DetailUjianController::class, 'add'])->name('detail-ujian.add');
                Route::get('detail-ujian/index/{id}', [DetailUjianController::class, 'index'])->name('detail-ujian.index');
                Route::post('detail-ujian/store/{id}', [DetailUjianController::class, 'add'])->name('detail-ujian.save');

                // File Uploader with filepond js
                Route::post('/tmp-upload',  [DetailUjianController::class, 'tmpUpload']);
                Route::delete('/tmp-delete',  [DetailUjianController::class, 'tmpDelete']);
            }
        );

        // Role onlu siswa
        Route::group(
            ['middleware' => ['role:Siswa']],
            function () {
                Route::get('daftar-ujian', [UjianSiswa::class, 'index'])->name('daftar-ujian.index');
                Route::get('daftar-ujian/pengerjaan/{id}', [UjianSiswa::class, 'create'])->name('daftar-ujian.create');
                Route::post('daftar-ujian/pengerjaan/{id}', [UjianSiswa::class, 'store'])->name('daftar-ujian.store');
                Route::get('nilai-ujian/{id}', [UjianSiswa::class, 'showNilai'])->name('daftar-ujian.nilai');
            }
        );
    }
);
