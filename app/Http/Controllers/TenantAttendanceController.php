<?php

namespace App\Http\Controllers;

use App\Models\TenantEvents;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantAttendanceController extends Controller
{
    /**
     * Start the attendance.
     * Why custom route? Because this is my CODEBASE xD
     */
    public function start(Request $request): RedirectResponse|View|Factory
    {
        $event = TenantEvents::find($request->input('event_id'));
        if(!$event) {
            session()->flash('warning', 'Starting attendance for an event that does not exist is not possible!');
            return redirect()->route('events.index');
        }
        return view('tenants.attendance.start', compact('event'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory
    {
        return view('tenants.attendance.index');

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
