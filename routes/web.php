<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CageController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AddCageController;
use App\Http\Controllers\AddAnimalController;

// Сохраняем старые URL
Route::get('login.php', [AuthController::class, 'showLogin'])->name('login');
Route::post('login.php', [AuthController::class, 'login']);
Route::get('vendor/logOut.php', [AuthController::class, 'logout'])->name('logout');
Route::get('index.php', [HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], 'cage.php', [CageController::class, 'show'])->name('cage');
Route::post('cage.php', [CageController::class, 'update']);
Route::post('cage.php/delete', [CageController::class, 'delete']);
Route::post('cage.php/delete-animal', [CageController::class, 'deleteAnimal']);

Route::get('animal.php', [AnimalController::class, 'show'])->name('animal');
Route::post('animal.php', [AnimalController::class, 'update']);
Route::post('animal.php/delete', [AnimalController::class, 'delete']);

Route::get('addAnimal.php', [AddCageController::class, 'show'])->name('add-cage');
Route::post('addAnimal.php', [AddCageController::class, 'store']);

Route::get('addBox.php', [AddAnimalController::class, 'show'])->name('add-animal');
Route::post('addBox.php', [AddAnimalController::class, 'store']); 