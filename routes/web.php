<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('guest')->group(function() {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login');
    Route::get('signup', [LoginController::class, 'signUp'])->name('signup.create');
    Route::post('signup', [LoginController::class, 'createAccount'])->name('signup.store');
    Route::controller(\App\Http\Controllers\OfficeLoginController::class)->group(function() {
        Route::get('/login/microsoft', 'redirectToProvider')->name('office.redirect');
        Route::get('login/microsoft/callback', 'handleProviderCallback')->name('office.login');
    });
});

Route::get('/', function() {
    return \Inertia\Inertia::render('Home', [
        'featured' => \App\Models\Hotel::first(),
    ]);
});
Route::controller(\App\Http\Controllers\BotManController::class)->group(function() {
    Route::match(['get', 'post'], '/botman', 'handle');
});
Route::controller(\App\Http\Controllers\DocumentationController::class)->group(function() {
    Route::get('/documentation', 'index')->name('documentation.index');

});

Route::controller(\App\Http\Controllers\FlightController::class)->group(function() {
    Route::resource('/flights', \App\Http\Controllers\FlightController::class);

});
Route::controller(\App\Http\Controllers\PackageController::class)->group(function() {
    Route::resource('/packages', \App\Http\Controllers\PackageController::class);
    Route::get('/package/filter', 'filter');
});

Route::controller(\App\Http\Controllers\HotelController::class)->group(function() {
    Route::resource('/hotels', \App\Http\Controllers\HotelController::class);

});

Route::get('/home', function() {
    return Inertia::render('Home');
})->name('home');

Route::middleware('auth')->group(function() {

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::controller(\App\Http\Controllers\UserController::class)->group(function() {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
        Route::get('/users/{user}/show', 'show')->name('users.show');
        Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        Route::post('/users/{user}/update', 'update')->name('users.update');
        Route::delete('/users/{user}/delete', 'delete')->name('users.delete');
    });

    //////////////////////////////////////////////
    /////////////// Backup  routes ///////////////
    /////////////////////////////////////////////
    Route::controller(\App\Http\Controllers\BackupController::class)->group(function() {
        Route::get('/backups', 'index')->name('backups.index');
        Route::get('/backups/database', 'dbBackup')->name('backups.dbBackup');
        Route::get('/backups/fullbackup', 'fullBackup')->name('backups.fullBackup');
        Route::get('/backups/destroy', 'destroy')->name('backups.destroy');
    });
    Route::controller(\App\Http\Controllers\TicketController::class)->group(function() {
        Route::resource('/tickets', \App\Http\Controllers\TicketController::class);

    });


});


