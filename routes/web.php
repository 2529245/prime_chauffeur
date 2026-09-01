<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'dashbaord'])
    ->name('home')
    ->middleware('auth');

Route::middleware('auth')->group(function () {

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
        Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
        Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
    });

    // Roles
    Route::resource('roles', RolesController::class);

    // Permissions
    Route::resource('permissions', PermissionsController::class);

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/export', [BookingController::class, 'export'])->name('export');
        Route::get('/today', [BookingController::class, 'today'])->name('today');
        Route::get('/tomorrow', [BookingController::class, 'tomorrow'])->name('tomorrow');
        Route::get('/{booking}/view-pdf', [BookingController::class, 'viewPdf'])->name('viewPdf');
        Route::get('/{booking}/download-pdf', [BookingController::class, 'downloadPdf'])->name('downloadPdf');
        Route::patch('/{booking}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });

    // Vehicles
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('index');
        Route::get('/create', [VehicleController::class, 'create'])->name('create');
        Route::post('/', [VehicleController::class, 'store'])->name('store');
        Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('show');
        Route::get('/{vehicle}/edit', [VehicleController::class, 'edit'])->name('edit');
        Route::put('/{vehicle}', [VehicleController::class, 'update'])->name('update');
        Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy');
        Route::get('/{vehicle}/export-bookings', [VehicleController::class, 'exportBookings'])->name('exportBookings');
    });

    // Drivers
    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::get('/', [DriverController::class, 'index'])->name('index');
        Route::get('/create', [DriverController::class, 'create'])->name('create');
        Route::post('/', [DriverController::class, 'store'])->name('store');
        Route::get('/{driver}', [DriverController::class, 'show'])->name('show');
        Route::get('/{driver}/edit', [DriverController::class, 'edit'])->name('edit');
        Route::put('/{driver}', [DriverController::class, 'update'])->name('update');
        Route::delete('/{driver}', [DriverController::class, 'destroy'])->name('destroy');
        Route::get('/{driver}/export-bookings', [DriverController::class, 'exportBookings'])->name('exportBookings');
    });

    // Driver Documents
    Route::prefix('documents/driver')->name('documents.driver.')->group(function () {
        Route::get('/', [DocumentController::class, 'driverIndex'])->name('index');
        Route::get('/create', [DocumentController::class, 'driverCreate'])->name('create');
        Route::post('/', [DocumentController::class, 'driverStore'])->name('store');
        Route::get('/{document}', [DocumentController::class, 'driverShow'])->name('show');
        Route::get('/{document}/edit', [DocumentController::class, 'driverEdit'])->name('edit');
        Route::put('/{document}', [DocumentController::class, 'driverUpdate'])->name('update');
        Route::get('/{document}/view', [DocumentController::class, 'driverView'])->name('view');
        Route::get('/{document}/download', [DocumentController::class, 'driverDownload'])->name('download');
        Route::delete('/{document}', [DocumentController::class, 'driverDestroy'])->name('destroy');
    });

    // Staff Documents
    Route::prefix('documents/staff')->name('documents.staff.')->group(function () {
        Route::get('/', [DocumentController::class, 'staffIndex'])->name('index');
        Route::get('/create', [DocumentController::class, 'staffCreate'])->name('create');
        Route::post('/', [DocumentController::class, 'staffStore'])->name('store');
        Route::get('/{document}', [DocumentController::class, 'staffShow'])->name('show');
        Route::get('/{document}/edit', [DocumentController::class, 'staffEdit'])->name('edit');
        Route::put('/{document}', [DocumentController::class, 'staffUpdate'])->name('update');
        Route::get('/{document}/view', [DocumentController::class, 'staffView'])->name('view');
        Route::get('/{document}/download', [DocumentController::class, 'staffDownload'])->name('download');
        Route::delete('/{document}', [DocumentController::class, 'staffDestroy'])->name('destroy');
    });

    // POS Machines
    Route::prefix('assets/pos-machines')->name('assets.pos-machines.')->group(function () {
        Route::get('/', [AssetController::class, 'posMachinesIndex'])->name('index');
        Route::get('/create', [AssetController::class, 'posMachinesCreate'])->name('create');
        Route::post('/', [AssetController::class, 'posMachinesStore'])->name('store');
        Route::get('/{posMachine}', [AssetController::class, 'posMachinesShow'])->name('show');
        Route::get('/{posMachine}/edit', [AssetController::class, 'posMachinesEdit'])->name('edit');
        Route::put('/{posMachine}', [AssetController::class, 'posMachinesUpdate'])->name('update');
        Route::delete('/{posMachine}', [AssetController::class, 'posMachinesDestroy'])->name('destroy');
    });

    // Mobile Phones
    Route::prefix('assets/mobile-phones')->name('assets.mobile-phones.')->group(function () {
        Route::get('/', [AssetController::class, 'mobilePhonesIndex'])->name('index');
        Route::get('/create', [AssetController::class, 'mobilePhonesCreate'])->name('create');
        Route::post('/', [AssetController::class, 'mobilePhonesStore'])->name('store');
        Route::get('/{mobilePhone}', [AssetController::class, 'mobilePhonesShow'])->name('show');
        Route::get('/{mobilePhone}/edit', [AssetController::class, 'mobilePhonesEdit'])->name('edit');
        Route::put('/{mobilePhone}', [AssetController::class, 'mobilePhonesUpdate'])->name('update');
        Route::delete('/{mobilePhone}', [AssetController::class, 'mobilePhonesDestroy'])->name('destroy');
    });

    // SIM Cards
    Route::prefix('assets/sim-cards')->name('assets.sim-cards.')->group(function () {
        Route::get('/', [AssetController::class, 'simCardsIndex'])->name('index');
        Route::get('/create', [AssetController::class, 'simCardsCreate'])->name('create');
        Route::post('/', [AssetController::class, 'simCardsStore'])->name('store');
        Route::get('/{simCard}', [AssetController::class, 'simCardsShow'])->name('show');
        Route::get('/{simCard}/edit', [AssetController::class, 'simCardsEdit'])->name('edit');
        Route::put('/{simCard}', [AssetController::class, 'simCardsUpdate'])->name('update');
        Route::delete('/{simCard}', [AssetController::class, 'simCardsDestroy'])->name('destroy');
    });

    // Asset Assignment
    Route::prefix('assets')->name('assets.')->group(function () {
        Route::post('/assign', [AssetController::class, 'assignAsset'])->name('assign');
        Route::post('/assignments/{assignment}/return', [AssetController::class, 'returnAsset'])->name('return');
    });

    // Staff
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/', [StaffController::class, 'store'])->name('store');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('show');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('destroy');
        Route::post('/{staff}/documents', [StaffController::class, 'storeDocument'])->name('documents.store');
        Route::get('/{staff}/documents/{document}/view', [StaffController::class, 'viewDocument'])->name('documents.view');
        Route::get('/{staff}/documents/{document}/download', [StaffController::class, 'downloadDocument'])->name('documents.download');
        Route::delete('/{staff}/documents/{document}', [StaffController::class, 'destroyDocument'])->name('documents.destroy');
    });
});

Route::fallback(fn () => redirect()->route('login'));