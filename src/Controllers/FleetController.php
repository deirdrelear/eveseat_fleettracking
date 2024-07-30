<?php

namespace drlear\FleetTracking\Controllers;

use Illuminate\Http\Request;
use drlear\FleetTracking\Models\Fleet;
use drlear\FleetTracking\Services\FleetService;
use drlear\Seat\Web\Controllers\Controller;

class FleetController extends Controller
{
    protected $fleetService;

    public function __construct(FleetService $fleetService)
    {
        $this->fleetService = $fleetService;
    }

    public function index()
    {
        $fleets = Fleet::with('commander')->paginate(10);
        return view('fleettracking::fleet.index', compact('fleets'));
    }

    public function create()
    {
        $fcSquads = $this->fleetService->getFCSquads();
        return view('fleettracking::fleet.create', compact('fcSquads'));
    }

    public function store(Request $request)
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

    public function show(Fleet $fleet)
    {
        $fleet->load('commander', 'participants');
        return view('fleettracking::fleet.show', compact('fleet'));
    }

    public function edit(Fleet $fleet)
    {
        $fcSquads = $this->fleetService->getFCSquads();
        return view('fleettracking::fleet.edit', compact('fleet', 'fcSquads'));
    }

    public function update(Request $request, Fleet $fleet)
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

    public function destroy(Fleet $fleet)
    {
        $fleet->delete();
        return redirect()->route('fleettracking.fleet.index')
            ->with('success', 'Fleet deleted successfully.');
    }
}
