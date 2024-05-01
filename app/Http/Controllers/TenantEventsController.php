<?php

namespace App\Http\Controllers;

use App\Models\TenantEvents;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory
    {
        return view('tenants.events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory
    {
        return view('tenants.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
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
    public function edit(string $id): RedirectResponse|View|Factory
    {
        $event = TenantEvents::find($id);
        if (!$event) {
            return redirect(route('events.index'))->with('error', 'You cannot edit an event that does not exist in the database.');
        }
        return view("tenants.events.edit", ["event" => $event]);
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
