<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;

/**
 * Class Account
 *
 * @package EtherScan\Modules
 *
 * Represents the account module of the etherscan.io api
 */
class Transaction extends AbstractHttpResource
{
    public const SORT_DESC = 'desc';
    public const SORT_ASC = 'asc';

    private $queryParams = ['module' => 'transaction'];

    /**
     * Check Contract Execution Status (if there was an error during contract execution)
     * "isError":"0" = Pass , "isError":"1" = Error during Contract Execution
     *
     * @param string $txhash
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getExecutionStatus(string $txhash): string
    {
        $finalQuery = array_merge(
            $this->queryParams,
            [
                'action'  => 'getstatus',
                'txhash' => $txhash,
            ]
        );

        $url =  $this->apiConnector->generateLink(
            $this->prefix,
            AbstractHttpResource::RESOURCE_API,
            $finalQuery
        );

        return $this->apiConnector->doRequest($url);
    }

    /**
     * Check Transaction Receipt Status (Only applicable for Post Byzantium fork transactions)
     * status: 0 = Fail, 1 = Pass. Will return null/empty value for pre-byzantium fork
     *
     * @param string $txhash
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReceiptStatus(string $txhash): string
    {
        $finalQuery = array_merge(
            $this->queryParams,
            [
                'action'  => 'gettxreceiptstatus',
                'txhash' => $txhash,
            ]
        );

        $url =  $this->apiConnector->generateLink(
            $this->prefix,
            AbstractHttpResource::RESOURCE_API,
            $finalQuery
        );

        return $this->apiConnector->doRequest($url);
    }
}
