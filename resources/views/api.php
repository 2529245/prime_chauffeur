<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactFilterController;

/* |--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| */

// Public contact routes
Route::prefix('contacts')->name('contacts.')->group(function(){
    Route::get('/mark_signed/{user_email}',[ContactFilterController::class, 'signed_user'])->name('signed_user');

});