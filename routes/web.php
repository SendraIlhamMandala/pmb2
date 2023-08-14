<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
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



//create route group
Route::middleware(['auth', 'verified'])->group(function () {
  
  Route::get('/dashboard', function () {
    return Inertia::render('HomeView');
  })->name('dashboard');
  
  Route::get('/tables', function () {
    return Inertia::render('TablesView');
  })->name('tables');
  
  Route::get('/profilez',function() {
    return Inertia::render('ProfileView', [
      'status' => session('status'),
  ]);
  })->name('profilez');

  

  Route::get('/forms', function () {
    return Inertia::render('FormsView');
  })->name('forms');


  // Route::get('/games',[GameController::class,'index'])->name('games');
//create resource for games

Route::resource('games', GameController::class);


  //inertia route style view
  Route::get('/styles',function
  () {
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
  Route::get('/error',function
  () {
    return Inertia::render('ErrorView');
  })->name('error');

  

});



Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
