<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TenantLoginController extends Controller
{
    public function login(Request $request): View|Factory
    {
        return view('tenants.auth.login');
    }
    public function authenticate(Request $request): void
    {
        // TODO: ...
    }
}
