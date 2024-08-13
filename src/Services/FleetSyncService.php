<?php

namespace Deirdrelear\Seat\FleetTracking\Services;

use Deirdrelear\Seat\FleetTracking\Models\Fleet;
use Seat\Web\Models\User;

class FleetSyncService
{
    protected $esiService;
    protected $fleetService;

    public function __construct(ESIService $esiService, FleetService $fleetService)
    {
        $this->esiService = $esiService;
        $this->fleetService = $fleetService;
    }

    public function syncAllFleets()
    {
        $fcSquadName = config('fleettracking.fc_squad_name');
        $fcSquad = \drlear\Seat\Web\Models\Squad::where('name', $fcSquadName)->first();

        if (!$fcSquad) {
            \Log::error("FC Squad not found: {$fcSquadName}");
            return false;
        }

        $fcs = $fcSquad->users;

        foreach ($fcs as $fc) {
            $this->syncFCFleets($fc);
        }

        return true;
    }

    protected function syncFCFleets(User $fc)
    {
        $accessToken = $fc->refresh_token; // Assuming the refresh token is stored in the user model
        $fleets = $this->esiService->getCharacterFleets($fc->character_id, $accessToken);

        if (!$fleets) {
            \Log::warning("Failed to get fleets for FC: {$fc->name}");
            return;
        }

        foreach ($fleets as $fleetData) {
            $fleet = Fleet::updateOrCreate(
                ['game_id' => $fleetData['fleet_id']],
                [
                    'name' => $this->generateFleetName($fleetData),
                    'fc_id' => $fc->id,
                    'start_time' => now(),
                    'status' => 'active',
                    'location' => $fleetData['solar_system_id'], // You might want to resolve this to a system name
                ]
            );

            $this->fleetService->syncFleet($fleet);
        }
    }

    protected function generateFleetName($fleetData)
    {
        $template = config('fleettracking.fleet_name_template');
        return strtr($template, [
            '%Y' => date('Y'),
            '%m' => date('m'),
            '%d' => date('d'),
            '%H' => date('H'),
            '%i' => date('i'),
        ]);
    }
}
