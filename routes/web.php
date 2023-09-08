<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\GameController;
use App\Http\Controllers\JalurDaftarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\UserController;
use App\Models\DataPribadi;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//   return Inertia::render('Welcome', [
//     'canLogin' => Route::has('login'),
//     'canRegister' => Route::has('register'),
//     'laravelVersion' => Application::VERSION,
//     'phpVersion' => PHP_VERSION,
//   ]);
// })->name('welcome');


Route::get('/', function () {
  return Inertia::render('User/IndexView', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
})->name('welcome');

//get gethtmlpage fromcontroller
Route::get('/gethtmlpage', [Controller::class, 'gethtmlpage'])->name('gethtmlpage');


//create route group
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {



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



  Route::get('verifikasi-pembayaran-user', [UserController::class, 'verifikasiPembayaranUserIndex'])->name('verifikasiPembayaranUserIndex');

  Route::resource('roles', RoleController::class);
  Route::get('/roles/delete/{id}', [RoleController::class, 'deleteOne'])->name('roles.deleteOne');
  Route::get('/roles/deletemultiple/{id}', [RoleController::class, 'deleteMultiple'])->name('roles.deleteMultiple');
  
  Route::resource('shifts', ShiftController::class);
  Route::get('/shifts/delete/{id}', [ShiftController::class, 'deleteOne'])->name('shifts.deleteOne');
  Route::get('/shifts/deletemultiple/{id}', [ShiftController::class, 'deleteMultiple'])->name('shifts.deleteMultiple');

  Route::resource('jalurs', JalurDaftarController::class);
  Route::get('/jalurs/delete/{id}', [JalurDaftarController::class, 'deleteOne'])->name('jalurs.deleteOne');
  Route::get('/jalurs/deletemultiple/{id}', [JalurDaftarController::class, 'deleteMultiple'])->name('jalurs.deleteMultiple');

  Route::resource('prodis', ProgramStudiController::class);
  Route::get('/prodis/delete/{id}', [ProgramStudiController::class, 'deleteOne'])->name('prodis.deleteOne');
  Route::get('/prodis/deletemultiple/{id}', [ProgramStudiController::class, 'deleteMultiple'])->name('prodis.deleteMultiple');


  Route::resource('tahuns', TahunController::class);
  Route::get('/tahuns/delete/{id}', [TahunController::class, 'deleteOne'])->name('tahun.deleteOne');
  Route::get('/tahuns/deletemultiple/{id}', [TahunController::class, 'deleteMultiple'])->name('tahun.deleteMultiple');


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

Route::middleware('auth', 'verified')->group(function () {

  Route::get('/dashboard', function () {

    if (Auth::user()->roles->first()->name == 'user') {
      return redirect()->route('user.data-pribadi');
    }

    return Inertia::render('HomeView');
  })->name('dashboard');

  Route::post('/data-pribadi/{id}', [UserController::class, 'setDataPribadi'])->name('user.set-data-pribadi');
  Route::post('/data-jalur/{id}', [UserController::class, 'setDataJalur'])->name('user.set-data-jalur');
  Route::get('/data-pribadi', [UserController::class, 'dataPribadi'])->name('user.data-pribadi');
  Route::get('/data-jalur', [UserController::class, 'dataJalur'])->name('user.data-jalur');
  Route::get('/verifikasi-pembayaran', [UserController::class, 'halamanVerifikasiPembayaran'])->name('HalamanVerifikasiPembayaran');
  Route::post('/verifikasi-pembayaran/{id}', [UserController::class, 'uploadVerifikasiPembayaran'])->name('uploadVerifikasiPembayaran');
  Route::post('/verifikasi-pembayaran-user/{id}', [UserController::class, 'verifikasiPembayaranUser'])->name('verifikasiPembayaranUser');
  Route::post('/verifikasi-voucher', [UserController::class, 'verifikasiVoucher'])->name('verifikasiVoucher');
  Route::get('/tunggu-verifikasi', [UserController::class, 'tungguVerifikasi'])->name('tungguVerifikasi');
  Route::get('/verifikasi-diterima', [UserController::class, 'diterimaVerifikasi'])->name('diterimaVerifikasi');

  Route::get('/cat', [Controller::class, 'cat']);
  Route::get('/datapribadicek', function () {

    $user = Auth::user();
    $user->dataPribadi;
    $user->asalSekolah;
    $user->alamat;
    $user->orangtua;
    $user->dataDaftar;
    $user->pindahan;
    $user->tambahan;

    $users = App\Models\User::all();
    $users->load('dataPribadi');
    $users->load('asalSekolah');

    return Inertia::render('User/UserView', [
      'user' => $user,
      'users' => $users
    ]);
  })->name('usercek');
 

  // Route::get('/user-dashboard', function () {
  //   return 123123;
  // })->name('user-dashboard');
});


Route::get('/getadmin', [Controller::class, 'getAdmin']);
Route::get('/createadmin', [Controller::class, 'createAdmin']);
Route::get('/link', function () {
  Artisan::call('storage:link');
});


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
