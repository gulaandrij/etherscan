<?php

namespace EtherScan\Resources;

use Exception;
use GuzzleHttp\Client;

/**
 * Does all the calls to the etherscan.io
 *
 * Class ApiConnector
 *
 * @package EtherScan\Resources
 */
class ApiConnector
{

    /**
     *
     * @var string
     */
    private $apiKey;

    /**
     * ApiConnector constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     *
     * @param  string     $prefix
     * @param  string     $resource
     * @param  array|null $queryParams
     * @return string
     */
    public function generateLink(string $prefix, string $resource, ?array $queryParams = null): string
    {
        $query = '';
        if (\is_array($queryParams) && \count($queryParams) > 0) {
            $queryParams['apiKey'] = $this->apiKey;
            $query = '?'.http_build_query($queryParams);
        }

        $url = sprintf(
            'https://%setherscan.io/%s%s',
            $prefix,
            $resource,
            $query
        );

        return $url;
    }

    /**
     *
     * @param  string $url
     * @return string
     * @throws \RuntimeException
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doRequest(string $url): string
    {
        $client = new Client();
        $res = $client->request('GET', $url);
        return $res->getBody()->getContents();
    }
}
