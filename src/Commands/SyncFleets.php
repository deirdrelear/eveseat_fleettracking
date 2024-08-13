<?php

namespace Deirdrelear\Seat\FleetTracking\Commands;

use Illuminate\Console\Command;
use Deirdrelear\Seat\FleetTracking\Services\FleetSyncService;

class SyncFleets extends Command
{
    protected $signature = 'fleettracking:sync';

    protected $description = 'Synchronize fleet information from ESI';

    private FleetSyncService $fleetSyncService;

    public function __construct(FleetSyncService $fleetSyncService)
    {
        parent::__construct();
        $this->fleetSyncService = $fleetSyncService;
    }

    public function handle(): int
    {
        $this->info('Starting fleet synchronization...');

        $result = $this->fleetSyncService->syncAllFleets();

        if ($result) {
            $this->info('Fleet synchronization completed successfully.');
            return Command::SUCCESS;
        } else {
            $this->error('Fleet synchronization failed.');
            return Command::FAILURE;
        }
    }
}