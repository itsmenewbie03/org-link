<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantCustomizationController extends Controller
{
    /**
    * Custom method for theme customization
    */
    public function theme(Request $request): RedirectResponse|View|Factory
    {
        if(tenant('plan') == 'nano') {
            return redirect()->route('dashboard')->with('error_message', 'You need to upgrade your plan to access this feature.');
        }

        if(is_null($request->input("prefersDarkMode"))) {
            return view('tenants.customizations.init');
        }
        return view('tenants.customizations.theme', ['prefersDarkMode' => $request->input("prefersDarkMode")]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }
}
