<?php

namespace App\Services;

use App\Exceptions\DomainsListFileNotFoundException;
use App\Interfaces\DomainListInterface;
use Illuminate\Support\Facades\Http;

class DomainListFromRemoteJsonService implements DomainListInterface
{
    private string $key = 'rootDomain';

    /**
     * @return array
     * @throws DomainsListFileNotFoundException
     */
    public function getDomainList(): array
    {
        $response = Http::get(env('DOMAIN_LIST_REMOTE_JSON_FILE', false));
        if ($response->successful()) {
            $websites_list = $response->json();
        } else {
            throw new DomainsListFileNotFoundException();
        }

        return collect($websites_list)->pluck($this->key)->toArray();
    }
}
