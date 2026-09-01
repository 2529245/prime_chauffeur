<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    // Handle password confirmation

    use ConfirmsPasswords;

    // Set redirect location
    protected $redirectTo = RouteServiceProvider::HOME;

    // Set controller middleware
    public function __construct()
    {
        $this->middleware('auth');
    }
}
