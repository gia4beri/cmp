<?php

use App\Models\OptionModel;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StaffController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StatController;

use App\Http\Middleware\RoleMiddleware;

// Home page route
Route::get('/', function () {
    $portal_logo = OptionModel::where('option_name', 'portal_logo')->get();
    return view('index', ['title' => 'სისტემაში შესვლა', 'portal_logo' => $portal_logo]);
})->name('login')->middleware('guest');

// Login and logout routes
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', function (){
    return redirect('/dashboard');
});
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth']], function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Services
    Route::get('/dashboard/services', [ServiceController::class, 'index'])->can('isAdmin');;
    Route::patch('/dashboard/services', [ServiceController::class, 'search'])->can('isAdmin');;
    Route::post('/dashboard/services', [ServiceController::class, 'create'])->can('isAdmin');;
    Route::get('/dashboard/services/delete', [ServiceController::class, 'delete'])->can('isAdmin');;
    Route::get('/dashboard/services/edit', [ServiceController::class, 'updateView'])->can('isAdmin');;
    Route::put('/dashboard/services', [ServiceController::class, 'update'])->can('isAdmin');;

    // Options
    Route::get('/dashboard/options', [OptionController::class, 'index'])->middleware('auth')->can('isAdmin');;
    Route::put('/dashboard/options', [OptionController::class, 'update'])->middleware('auth')->can('isAdmin');;

    // Staff
    Route::get('/dashboard/staff', [StaffController::class, 'index'])->can('isAdmin');
    Route::post('/dashboard/staff', [StaffController::class, 'create'])->can('isAdmin');;
    Route::get('/dashboard/staff/delete', [StaffController::class, 'delete'])->can('isAdmin');;
    Route::patch('/dashboard/staff', [StaffController::class, 'search'])->can('isAdmin');;
    Route::get('/dashboard/staff/edit', [StaffController::class, 'updateView'])->can('isAdmin');;
    Route::put('/dashboard/staff', [StaffController::class, 'update'])->can('isAdmin');;

    // Users
    Route::get('/dashboard/users', [UserController::class, 'index'])->can('isAdminOrReceptionOrDoctor');;
    Route::get('/dashboard/users/edit', [UserController::class, 'updateView'])->can('isAdminOrReception');
    Route::post('/dashboard/users', [UserController::class, 'create'])->can('isAdminOrReception');
    Route::get('/dashboard/users/delete', [UserController::class, 'delete'])->can('isAdmin');;
    Route::patch('/dashboard/users', [UserController::class, 'search'])->can('isAdminOrReceptionOrDoctor');
    Route::put('/dashboard/users', [UserController::class, 'update'])->can('isAdminOrReception');
    Route::post('/dashboard/users/files', [UserController::class, 'files'])->can('isAdminOrReceptionOrDoctor');
    Route::get('/dashboard/users/files/delete', [UserController::class, 'fileDelete'])->can('isAdmin');

    Route::get('/dashboard/users/profile', [UserController::class, 'profileView'])->can('isAdminOrReceptionOrDoctor');
    Route::post('/dashboard/users/profile/consultation', [UserController::class, 'consultation'])->can('isAdminOrReceptionOrDoctor');
    Route::get('/dashboard/users/profile/consultation/view', [UserController::class, 'consultationView'])->can('isAdminOrReceptionOrDoctor');
    Route::get('/dashboard/users/profile/consultation/delete', [UserController::class, 'consultation_delete'])->can('isAdmin');

    // Invoices
    Route::get('/dashboard/invoices', [InvoiceController::class, 'index'])->can('isAdminOrReception');;
    Route::patch('/dashboard/invoices', [InvoiceController::class, 'search'])->can('isAdminOrReception');
    Route::post('/dashboard/invoices', [InvoiceController::class, 'create'])->can('isAdminOrReception');
    Route::get('/dashboard/invoices/delete', [InvoiceController::class, 'delete'])->can('isAdmin');
    Route::get('/dashboard/invoices/pay', [InvoiceController::class, 'pay'])->can('isAdminOrReception');
    Route::get('/dashboard/invoices/view', [InvoiceController::class, 'view'])->can('isAdminOrReception');

    // Stats
    Route::get('/dashboard/stats', [StatController::class, 'index'])->can('isAdmin');;
    Route::get('/dashboard/export', [StatController::class, 'export'])->can('isAdmin');;

});

