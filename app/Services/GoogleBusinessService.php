<?php

namespace App\Services;

use Google\Client;
use Google\Service\MyBusinessAccountManagement;
use Google\Service\MyBusinessBusinessInformation;

class GoogleBusinessService
{
    protected Client $client;
    protected MyBusinessAccountManagement $accountService;
    protected MyBusinessBusinessInformation $infoService;

    public function __construct(array $credentials)
    {
        $this->client = new Client();
        $this->client->setAccessToken($credentials);

        $this->accountService = new MyBusinessAccountManagement($this->client);
        $this->infoService = new MyBusinessBusinessInformation($this->client);
    }

    public function getAccounts(): array
    {
        $accounts = $this->accountService->accounts->listAccounts();
        return $accounts->getAccounts() ?? [];
    }

  // In App\Services\GoogleBusinessService.php

// ... (other methods)

   public function getLocations(string $accountName): array
{
    $params = [
        // Remove 'primaryCategory' and 'metadata'.
        // 'languageCode' is also generally not a supported field in the list read mask.
        'readMask' => 'name,title,storeCode,websiteUri', 
    ];

    $locations = $this->infoService->accounts_locations->listAccountsLocations($accountName, $params);

    return $locations->getLocations() ?? [];
}

// ... (other methods)


public function getAllProfiles(): array
{
    $profiles = [];

    foreach ($this->getAccounts() as $account) {
        $locations = $this->getLocations($account->name);

        $profiles[] = [
            'account' => [
                'name' => $account->name,
                'accountName' => $account->accountName ?? null,
                'type' => $account->type ?? null,
            ],
            'locations' => array_map(function ($loc) {
                return [
                    'locationName' => $loc->getName(),
                    'title' => $loc->getTitle(),
                    'storeCode' => $loc->getStoreCode(),
                    'category' => optional($loc->getPrimaryCategory())->getDisplayName(),
                    'website' => $loc->getWebsiteUri(),
                ];
            }, $locations)
        ];
    }

    return $profiles;
}

}
