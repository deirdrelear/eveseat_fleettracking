<?php

return [
    'esi_client_id' => env('FLEET_TRACKING_ESI_CLIENT_ID'),
    'esi_secret_key' => env('FLEET_TRACKING_ESI_SECRET_KEY'),
    'esi_callback_url' => env('FLEET_TRACKING_ESI_CALLBACK_URL'),
    'fleet_name_template' => env('FLEET_TRACKING_NAME_TEMPLATE', '[CORP] Fleet %Y-%m-%d'),
    'fc_squad_name' => env('FLEET_TRACKING_FC_SQUAD_NAME', 'Fleet Commanders'),
];
