<?php

namespace Deirdrelear\Seat\FleetTracking\Controllers;

use Illuminate\Http\Request;
use Deirdrelear\Seat\FleetTracking\Models\Fleet;
use Deirdrelear\Seat\FleetTracking\Models\FleetParticipant;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FleetParticipantController extends Controller
{
    public function join(Request $request, Fleet $fleet): RedirectResponse
    {
        $validatedData = $request->validate([
            'ship_type_id' => 'required|integer',
        ]);

        $participant = new FleetParticipant([
            'character_id' => auth()->user()->id,
            'ship_type_id' => $validatedData['ship_type_id'],
            'join_time' => now(),
        ]);

        $fleet->participants()->save($participant);

        return redirect()->route('fleettracking.fleet.show', $fleet->id)
            ->with('success', 'Joined the fleet successfully.');
    }

    public function leave(Fleet $fleet): RedirectResponse
    {
        $participant = $fleet->participants()
            ->where('character_id', auth()->user()->id)
            ->whereNull('leave_time')
            ->first();

        if ($participant) {
            $participant->update(['leave_time' => now()]);
            return redirect()->route('fleettracking.fleet.show', $fleet->id)
                ->with('success', 'Left the fleet successfully.');
        }

        return redirect()->route('fleettracking.fleet.show', $fleet->id)
            ->with('error', 'You are not in this fleet.');
    }
}