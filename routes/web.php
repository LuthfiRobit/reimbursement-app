<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ReimbursementController;
use App\Models\User;
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

// Route::get('/', function () {
//     return view('home');
// });

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware(['auth'])->group(
    function () {

        Route::get('/', [ReimbursementController::class, 'home']);

        Route::prefix('karyawan')->name('karyawan.')->middleware('can:direktur-role')->group(function () {
            Route::get('/', [KaryawanController::class, 'index'])->name('index');
            Route::get('/list', [KaryawanController::class, 'list'])->name('list');
            Route::get('/{id}', [KaryawanController::class, 'show'])->name('show');
            Route::post('/store', [KaryawanController::class, 'store'])->name('store');
            Route::put('/{id}/update', [KaryawanController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [KaryawanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('reimbursement')->name('reimbursement.')->group(function () {
            Route::get('/', [ReimbursementController::class, 'index'])->name('index');
            Route::get('/list', [ReimbursementController::class, 'list'])->name('list');
            Route::get('/{id}', [ReimbursementController::class, 'show'])->name('show');
            Route::post('/store', [ReimbursementController::class, 'store'])->name('store')->middleware('can:staff-role');
            Route::put('/{id}/update', [ReimbursementController::class, 'update'])->name('update')->middleware('can:staff-role');
            Route::delete('/{id}/destroy', [ReimbursementController::class, 'destroy'])->name('destroy')->middleware('can:staff-role');
            Route::post('/approve', [ReimbursementController::class, 'approve'])->name('approve');
            Route::post('/approve/multiple', [ReimbursementController::class, 'approveMultiple'])->name('approve.multiple');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);
