<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
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

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

//get gethtmlpage fromcontroller
Route::get('/gethtmlpage', [Controller::class, 'gethtmlpage'])->name('gethtmlpage');



//create route group
Route::middleware(['auth', 'verified'  ])->group(function () {

  Route::get('/dashboard', function () {
    return Inertia::render('HomeView');
  })->name('dashboard');

  Route::get('/tables', function () {
    return Inertia::render('TablesView');
  })->name('tables');

  Route::get('/profilez', function () {
    return Inertia::render('ProfileView', [
      'status' => session('status'),
    ]);
  })->name('profilez');



  Route::get('/forms', function () {
    return Inertia::render('FormsView');
  })->name('forms');




  Route::resource('roles', RoleController::class);
  Route::get('/roles/delete/{id}', [RoleController::class, 'deleteOne'])->name('roles.deleteOne');
  Route::get('/roles/deletemultiple/{id}', [RoleController::class, 'deleteMultiple'])->name('roles.deleteMultiple');

  Route::resource('games', GameController::class)->middleware('verified');
  Route::get('/getgames', [GameController::class, 'getGames']);
  Route::get('/games/deleteone/{id}', [GameController::class, 'deleteOne'])->name('games.deleteOne');
  Route::get('/games/deletemultiple/{id}', [GameController::class, 'deleteMultiple'])->name('games.deleteMultiple');


  Route::resource('users', UserController::class);


  //inertia route style view
  Route::get('/styles', function () {
    return Inertia::render('StylesView');
  })->name('styles');

  Route::get('/ui', function () {
    return Inertia::render('UiView');
  })->name('ui');

  //route responsive
  Route::get('/responsive', function () {
    return Inertia::render('ResponsiveView');
  })->name('responsive');



  //inertia route error view
  Route::get('/error', function () {
    return Inertia::render('ErrorView');
  })->name('error');
});

Route::get('/cat',[Controller::class, 'cat'] )->middleware('role:admin');
Route::get('/getadmin',[Controller::class, 'getAdmin'] );

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
