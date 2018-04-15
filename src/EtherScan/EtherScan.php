<?php

namespace EtherScan;

use EtherScan\Modules\Account;
use EtherScan\Modules\Stats;
use EtherScan\Resources\AbstractHttpResource;
use EtherScan\Resources\ApiConnector;

/**
 * Class EtherScan
 *
 * @package EtherScan
 *
 * The main class for using etherscan.io's api
 */
class EtherScan
{
    const PREFIX_API = 'api.';
    const PREFIX_TESTNET = 'testnet.';
    const PREFIX_ROPSTEN = 'ropsten.';
    const PREFIX_RINKEBY = 'rinkeby.';
    const PREFIX_KOVAN = 'kovan.';

    /**
     * @var ApiConnector
     */
    private $apiConnector;

    public function __construct(ApiConnector $apiConnector)
    {
        $this->apiConnector = $apiConnector;
    }

    /**
     * @param string $prefix
     * @return Stats
     */
    public function getStats(string $prefix = EtherScan::PREFIX_API): Stats
    {
        return new Stats($this->apiConnector, $prefix);
    }

    /**
     * @param string $prefix
     * @return Account
     */
    public function getAccount(string $prefix = EtherScan::PREFIX_API): Account
    {
        return new Account($this->apiConnector, $prefix);
    }

    /**
     * @param string $hash
     * @return string
     */
    public function getTxLink(string $hash): string
    {
        return $this->apiConnector->generateLink('', AbstractHttpResource::RESOURCE_TX.'/'.$hash);
    }

    /**
     * @param string $address
     * @return string
     */
    public function getAddressLink(string $address): string
    {
        return $this->apiConnector->generateLink('', AbstractHttpResource::RESOURCE_ADDRESS.'/'.$address);
    }

    /**
     * Enlists the tasks included in the array into the eventloop and
     * calls them together
     *
     * @param array $calls
     */
    public function callGroupAsync(array $calls): void
    {
        foreach ($calls as $call) {
            $this->apiConnector->enlistRequest($call[0], $call[1] ?? null, $call[2] ?? null, $call[3] ?? null);
        }

        $this->apiConnector->getEventLoop()->run();
    }
}
