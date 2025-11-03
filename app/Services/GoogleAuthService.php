<?php

namespace App\Services;

use Google\Client;

class GoogleAuthService
{
    protected Client $client;

   public function __construct(int $businessId, int $platformId)
{
    $this->client = new Client();
    $this->client->setClientId(config('services.google.client_id'));
    $this->client->setClientSecret(config('services.google.client_secret'));
    $this->client->setRedirectUri(route('platform.google.callback', [$businessId, $platformId]));
    $this->client->setAccessType('offline');
    $this->client->addScope('https://www.googleapis.com/auth/business.manage');
}


    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function handleCallback(string $code): array
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->client->setAccessToken($token);
        return $token;
    }

    public function refreshIfNeeded(array $credentials): array
    {
        $this->client->setAccessToken($credentials);

        if ($this->client->isAccessTokenExpired()) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            return array_merge($credentials, $newToken);
        }

        return $credentials;
    }
}

