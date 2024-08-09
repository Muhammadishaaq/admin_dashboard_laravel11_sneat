<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;


use App\Http\Controllers\Admin\{
    DashboardController,

};


/* admin login  */
Route::get('/', [AuthController::class, 'index'])->name('admin.loginPage');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login');


Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

});



Route::get('/create-link', function () {
    $storagePath = public_path('storage');
    if (file_exists($storagePath)) {
        unlink($storagePath);
    }
    symlink(storage_path('/app/public'), $storagePath);
    return 'Symlink has been created';
});



Route::get('/db', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return "seed";
});