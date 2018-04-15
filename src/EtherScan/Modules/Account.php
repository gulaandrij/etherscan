<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;
use InvalidArgumentException;

/**
 * Class Account
 *
 * @package EtherScan\Modules
 *
 * Represents the account module of the etherscan.io api
 */
class Account extends AbstractHttpResource
{
    public const SORT_DESC = 'desc';
    public const SORT_ASC = 'asc';

    private $queryParams = ['module' => 'account'];

    /**
     * @param string $address
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function getBalance(string $address): string
    {
        $url = $this->getBalanceLink($address);
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @param string $address
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getBalanceLink(string $address): string
    {
        if (!ctype_alnum($address)) {
            throw new InvalidArgumentException('Argument address is invalid');
        }

        $finalQuery = array_merge(
            $this->queryParams,
            [
             'action'  => 'balance',
             'address' => $address,
             'tag'     => 'latest',
            ]
        );
        return $this->apiConnector->generateLink(
            $this->prefix,
            AbstractHttpResource::RESOURCE_API,
            $finalQuery
        );
    }

    /**
     * @param array $addressList
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function getBalances(array $addressList): string
    {
        $url = $this->getBalancesLink($addressList);
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @param array $addressList
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getBalancesLink(array $addressList): string
    {
        if (count($addressList) < 1) {
            throw new InvalidArgumentException('Argument addressList is invalid');
        }

        $finalQuery = array_merge(
            $this->queryParams,
            [
             'action'  => 'balancemulti',
             'address' => implode(',', $addressList),
             'tag'     => 'latest',
            ]
        );
        return $this->apiConnector->generateLink(
            $this->prefix,
            AbstractHttpResource::RESOURCE_API,
            $finalQuery
        );
    }

    /**
     * @param string $address
     * @param int    $page
     * @param int    $pageSize
     * @param string $sort
     * @return string
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function getTransactions(string $address, int $page, int $pageSize, string $sort): string
    {
        $url = $this->getTransactionsLink($address, $page, $pageSize, $sort);
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @param string $address
     * @param int    $page
     * @param int    $pageSize
     * @param string $sort
     * @return string
     *
     * @throws \Exception
     * @throws InvalidArgumentException
     */
    public function getTransactionsLink(string $address, int $page = 1, int $pageSize = 25, string $sort = Account::SORT_DESC): string
    {
        if (!ctype_alnum($address)) {
            throw new InvalidArgumentException('Argument address is invalid');
        }

        if ($sort !== self::SORT_ASC && $sort !== self::SORT_DESC) {
            throw new InvalidArgumentException('Argument sort is invalid');
        }
        $finalQuery = array_merge(
            $this->queryParams,
            [
             'action'  => 'txlist',
             'address' => $address,
             'offset'  => $pageSize,
             'page'    => $page,
             'sort'    => $sort,
            ]
        );
        return $this->apiConnector->generateLink(
            $this->prefix,
            AbstractHttpResource::RESOURCE_API,
            $finalQuery
        );
    }
}
