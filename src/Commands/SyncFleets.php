<?php

namespace drlear\FleetTracking\Commands;

use Illuminate\Console\Command;
use drlear\FleetTracking\Services\FleetSyncService;

class SyncFleets extends Command
{
    protected $signature = 'fleettracking:sync';

    protected $description = 'Synchronize fleet information from ESI';

    private $fleetSyncService;

    public function __construct(FleetSyncService $fleetSyncService)
    {
        parent::__construct();
        $this->fleetSyncService = $fleetSyncService;
    }

    public function handle()
    {
        $this->info('Starting fleet synchronization...');

        $result = $this->fleetSyncService->syncAllFleets();

        if ($result) {
            $this->info('Fleet synchronization completed successfully.');
        } else {
            $this->error('Fleet synchronization failed.');
        }
    }
}
