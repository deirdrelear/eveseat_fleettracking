<?php

namespace Drlear\FleetTracking\Controllers;

use Illuminate\Http\Request;
use Drlear\FleetTracking\Models\Fleet;
use Drlear\FleetTracking\Services\FleetService;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FleetController extends Controller
{
    protected FleetService $fleetService;

    public function __construct(FleetService $fleetService)
    {
        $this->fleetService = $fleetService;
    }

    public function index(): View
    {
        $fleets = Fleet::with('commander')->paginate(10);
        return view('fleettracking::fleet.index', compact('fleets'));
    }

    public function create(): View
    {
        $fcSquads = $this->fleetService->getFCSquads();
        return view('fleettracking::fleet.create', compact('fcSquads'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fc_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'status' => 'required|in:active,inactive,completed',
            'location' => 'required|string|max:255',
            'doctrine' => 'nullable|string|max:255',
        ]);

        $fleet = Fleet::create($validatedData);

        return redirect()->route('fleettracking.fleet.show', $fleet->id)
            ->with('success', 'Fleet created successfully.');
    }

    public function show(Fleet $fleet): View
    {
        $fleet->load('commander', 'participants');
        return view('fleettracking::fleet.show', compact('fleet'));
    }

    public function edit(Fleet $fleet): View
    {
        $fcSquads = $this->fleetService->getFCSquads();
        return view('fleettracking::fleet.edit', compact('fleet', 'fcSquads'));
    }

    public function update(Request $request, Fleet $fleet): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fc_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'status' => 'required|in:active,inactive,completed',
            'location' => 'required|string|max:255',
            'doctrine' => 'nullable|string|max:255',
        ]);

        $fleet->update($validatedData);

        return redirect()->route('fleettracking.fleet.show', $fleet->id)
            ->with('success', 'Fleet updated successfully.');
    }

    public function destroy(Fleet $fleet): RedirectResponse
    {
        $fleet->delete();
        return redirect()->route('fleettracking.fleet.index')
            ->with('success', 'Fleet deleted successfully.');
    }
}