<?php

namespace Deirdrelear\Seat\FleetTracking\Services;

use Seat\Web\Models\Squad;
use Deirdrelear\Seat\FleetTracking\Models\Fleet;
use Deirdrelear\Seat\FleetTracking\Services\ESIService;

class FleetService
{
    protected $esiService;

    public function __construct(ESIService $esiService)
    {
        $this->esiService = $esiService;
    }

    public function getFCSquads()
    {
        return Squad::where('name', 'like', '%FC%')->get();
    }

    public function syncFleet(Fleet $fleet)
    {
        $fleetInfo = $this->esiService->getFleetInfo($fleet->game_id, $fleet->commander->refresh_token);
        if (!$fleetInfo) {
            return false;
        }

        $fleet->update([
            'status' => $fleetInfo['is_free_move'] ? 'active' : 'inactive',
            'location' => $fleetInfo['solar_system_id'], // You might want to resolve this to a system name
        ]);

        $members = $this->esiService->getFleetMembers($fleet->game_id, $fleet->commander->refresh_token);
        if (!$members) {
            return false;
        }

        // Update fleet participants
        // This is a simplified version, you might want to add more logic here
        $fleet->participants()->delete();
        foreach ($members as $member) {
            $fleet->participants()->create([
                'character_id' => $member['character_id'],
                'ship_type_id' => $member['ship_type_id'],
                'join_time' => now(),
            ]);
        }

        return true;
    }
}
