<?php

namespace App\Services;

use Google\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GoogleReviewService
{
    protected Client $client;
    protected string $account;
    protected string $location;
    protected array $credentials;

    public function __construct(array|string $credentials, string $account, string $location)
    {
        // ensure credentials is array
        if (is_string($credentials)) {
            $credentials = json_decode($credentials, true) ?: [];
        }
        $this->credentials = $credentials;

        $this->client = new Client();

        // IMPORTANT: set client id/secret so refresh works
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        if ($clientId) $this->client->setClientId($clientId);
        if ($clientSecret) $this->client->setClientSecret($clientSecret);

        // attach token (if any)
        if (!empty($this->credentials)) {
            $this->client->setAccessToken($this->credentials);
        }

        // If token expired and we have refresh token, refresh now
        if ($this->client->isAccessTokenExpired() && !empty($this->credentials['refresh_token'])) {
            $new = $this->client->fetchAccessTokenWithRefreshToken($this->credentials['refresh_token']);
            // merge known fields so we don't lose refresh_token if provider doesn't return it on refresh
            $this->credentials = array_merge($this->credentials, $new);
            $this->client->setAccessToken($this->credentials);
        }

        $this->account = $account;
        $this->location = $location;
    }

    protected function http()
    {
        // use authorize() so Authorization header is added
        return $this->client->authorize();
    }

    protected function baseUrl(): string
    {
        return 'https://mybusiness.googleapis.com/v4';
    }

    /**
     * Return the currently used credentials (useful to persist if refreshed)
     */
    public function getCredentials(): array
    {
        return $this->credentials;
    }
    public function listAccountsAndLocations()
    {
        $response = $this->http()->request('GET', "{$this->baseUrl()}/accounts");
        $accounts = json_decode((string)$response->getBody(), true);
        foreach ($accounts['accounts'] ?? [] as $account) {
            $accName = $account['name'];
            $locResponse = $this->http()->request('GET', "{$this->baseUrl()}/{$accName}/locations");
            $locations = json_decode((string)$locResponse->getBody(), true);
            Log::info("Account {$accName} locations: ", $locations);
        }
    }

    public function listReviews(int $pageSize = 50): array
    {
        try {
            $url = "{$this->baseUrl()}/{$this->account}/{$this->location}/reviews";
            $response = $this->http()->request('GET', $url, [
                'query' => ['pageSize' => $pageSize],
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (RequestException $e) {
            // try to decode response body for readable errors
            $body = $e->getResponse()?->getBody()?->__toString();
            $decoded = $body ? json_decode($body, true) : null;
            return ['error' => $decoded ?? $e->getMessage()];
        }
    }

   

// public function replyToReview(string $reviewId, string $comment): array
// {
//     try {
//         $url = "{$this->baseUrl()}/{$this->account}/{$this->location}/reviews/{$reviewId}/reply";

//         $response = $this->http()->request('POST', $url, [
//             'json' => ['comment' => $comment],
//         ]);

//         // Decode the response safely
//         $decoded = json_decode((string)$response->getBody(), true);
//  Log::info("Replied to review {$reviewId}", [
//             'response' => $decoded ?? ['empty' => true],
//         ]);        // Always return an array (even if API gives empty)
//         return $decoded ?? ['success' => true, 'message' => 'Reply posted successfully.'];

//     } catch (RequestException $e) {
//         $body = $e->getResponse()?->getBody()?->__toString();
//         $decoded = $body ? json_decode($body, true) : null;

//         // Always return a consistent array with error info
//         return [
//             'error' => $decoded ?? [
//                 'message' => $e->getMessage(),
//                 'status' => $e->getCode(),
//             ]
//         ];
//     } catch (\Throwable $t) {
//         // Fallback for any unexpected errors
//         return [
//             'error' => [
//                 'message' => $t->getMessage(),
//                 'status' => $t->getCode(),
//             ]
//         ];
//     }
// }

public function replyToReview(string $reviewId, string $comment): array
{
    try {
        $url = "{$this->baseUrl()}/{$this->account}/{$this->location}/reviews/{$reviewId}/reply";

        
        $response = $this->http()->request('PUT', $url, [
            'json' => ['comment' => $comment],
        ]);

        $decoded = json_decode((string)$response->getBody(), true);

        Log::info("✅ Successfully replied to review {$reviewId}", [
            'response' => $decoded ?? ['empty' => true],
        ]);

        return $decoded ?? ['success' => true, 'message' => 'Reply posted successfully.'];

    } catch (RequestException $e) {
        $body = $e->getResponse()?->getBody()?->__toString();
        $decoded = $body ? json_decode($body, true) : null;

        Log::error("❌ Failed to reply to review {$reviewId}", [
            'error' => $decoded ?? $e->getMessage(),
        ]);

        return [
            'error' => $decoded ?? [
                'message' => $e->getMessage(),
                'status' => $e->getCode(),
            ]
        ];
    } catch (\Throwable $t) {
        Log::error("🔥 Unexpected error replying to review {$reviewId}", [
            'error' => $t->getMessage(),
        ]);

        return [
            'error' => [
                'message' => $t->getMessage(),
                'status' => $t->getCode(),
            ]
        ];
    }
}


}



