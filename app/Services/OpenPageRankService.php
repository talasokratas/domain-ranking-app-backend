<?php

namespace App\Services;

use App\Exceptions\OpenPageRankServiceException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


/**
 * Class OpenPageRankService.
 */
class OpenPageRankService
{
    private string $api_url;
    private string $api_key;
    private Client $client;

    public function __construct(Client $client = null)
    {
        $this->api_url = config('openrankapi.url');
        $this->api_key = config('openrankapi.key');
        $this->client = $client ?? new Client();
    }

    /**
     * @param array $domains
     * @return array
     * @throws OpenPageRankServiceException
     */
    public function getPagesData(array $domains): array
    {
        $batchSize = 100; //set according to api response limit
        $batches = array_chunk($domains, $batchSize);
        $results = [];
        foreach ($batches as $batch) {
            try {
                $response = $this->client->request('get', $this->api_url, [
                    'headers' => [
                        'API-OPR' => $this->api_key
                    ],
                    'query' => [
                        'domains' => $batch
                    ],
                ]);
            } catch (GuzzleException $exception) {
                throw new OpenPageRankServiceException($exception);
            }

            $response_data = json_decode($response->getBody());
            if(isset($response_data->response)) {
                $results = array_merge($results, $response_data->response);
            }
        }

        return $results;
    }
}

