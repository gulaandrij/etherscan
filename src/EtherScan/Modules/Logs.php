<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;
use InvalidArgumentException;

/**
 * Class Stats
 *
 * @package EtherScan\Modules
 *
 * Represents the stats module of the etherscan.io api
 */
class Logs extends AbstractHttpResource
{

    private $queryParams = ['module' => 'logs'];

    /**
     *
     * @param string $address
     * @param int    $fromBlock
     * @param string $toBlock
     * @param array  $topicFilter
     *
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLogs(string $address, int $fromBlock = 0, $toBlock = 'latest', array $topicFilter = []): string
    {
        $url = $this->getLogsLink($address, $fromBlock, $toBlock, $topicFilter);
        return $this->apiConnector->doRequest($url);
    }

    /**
     *
     * @param  string      $address
     * @param  int         $fromBlock,
     * @param  int|string  $toBlock,
     * @param  $topicFilter
     * @return string
     * @throws InvalidArgumentException
     */
    public function getLogsLink(string $address, int $fromBlock = 0, $toBlock = 'latest', array $topicFilter = []): string
    {
        if ($address !== null && !ctype_alnum($address)) {
            throw new InvalidArgumentException('Argument address is invalid');
        }

        if ($toBlock !== 'latest' && (int) $toBlock !== $toBlock) {
            throw new InvalidArgumentException('Argument toBlock is invalid');
        }

        $params = ['action' => 'getLogs'];

        if ($address !== null) {
            $params['address'] = $address;
        }

        if ($fromBlock !== null) {
            $params['fromBlock'] = $fromBlock;
        }

        if ($toBlock !== null) {
            $params['toBlock'] = $toBlock;
        }

        if ($topicFilter !== []) {
            $params = array_merge($params, $topicFilter);
        }

        $finalQuery = array_merge($this->queryParams, $params);

        return $this->apiConnector->generateLink(
            $this->prefix,
            AbstractHttpResource::RESOURCE_API,
            $finalQuery
        );
    }
}
