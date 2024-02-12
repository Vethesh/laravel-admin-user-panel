<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthManager;
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

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get('/login', [AuthManager::class, 'login'])->name('login');

Route::post('/login', [AuthManager::class, 'loginpost'])->name('login.post');


Route::get('/register', [AuthManager::class, 'register'])->name('register');

Route::post('/register', [AuthManager::class, 'registerpost'])->name('register.post');

Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('/admin/dashboard/{detail}/edit', [AdminController::class, 'edit'])->name('admin.edit');

Route::put('/admin/dashboard/{detail}/update', [AdminController::class, 'update'])->name('admin.update');

Route::prefix('admin')->group(function () {
    Route::delete('/dashboard/{detail}/destroy', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::put('/admin/dashboard/{detail}/activate', [AdminController::class, 'activate'])->name('admin.activate');

Route::put('/admin/dashboard/{detail}/deactivate', [AdminController::class, 'deactivate'])->name('admin.deactivate');

Route::get('/admin/change-password/{user}', [AdminController::class, 'showChangePasswordForm'])->name('admin.change-password.form');
Route::put('/admin/change-password/{user}', [AdminController::class, 'updatePassword'])->name('admin.change-password.update');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', function () {
        return "hi";
    });


});





