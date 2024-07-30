<?php

namespace drlear\FleetTracking\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ESIService
{
    private $client;
    private $clientId;
    private $secretKey;
    private $callbackUrl;

    public function __construct($clientId, $secretKey, $callbackUrl)
    {
        $this->client = new Client([
            'base_uri' => 'https://esi.evetech.net/latest/',
            'timeout'  => 5.0,
        ]);
        $this->clientId = $clientId;
        $this->secretKey = $secretKey;
        $this->callbackUrl = $callbackUrl;
    }

    public function getFleetInfo($fleetId, $accessToken)
    {
        try {
            $response = $this->client->request('GET', "fleets/{$fleetId}/", [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Handle exception
            return null;
        }
    }

    public function getFleetMembers($fleetId, $accessToken)
    {
        try {
            $response = $this->client->request('GET', "fleets/{$fleetId}/members/", [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Handle exception
            return null;
        }
    }

    // Add more methods for other ESI endpoints as needed
}
