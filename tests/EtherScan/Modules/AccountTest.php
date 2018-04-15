<?php

namespace Tests\EtherScanTest\Modules;

use EtherScan\Modules\Account;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

/**
 * Class AccountTest
 *
 * @package Tests\EtherScanTest\Modules
 */
class AccountTest extends TestCase
{

    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';

    private $prefix = 'api.';

    private $conn;

    private $account;

    private $address = '0xbb9bc244d798123fde783fcc1c72d3bb8c189413';

    private $getBalanceAsyncResponce = [
                                        'status'  => 1,
                                        'message' => 'OK',
                                        'result'  => '29336202160022049953',
                                       ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector($this->apiKey);
        $this->account = new Account($this->conn, $this->prefix);
    }

    public function testGetBalance()
    {
        $responce = $this->account->getBalance($this->address);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);

        $floatResult = (float) $responceDecoded['result'];

        $this->assertInternalType('float', $floatResult);
    }

    public function testGetBalances()
    {
        $responce = $this->account->getBalances([$this->address]);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);

        $this->assertTrue(is_array($responceDecoded['result']));
        $this->assertArrayHasKey(0, $responceDecoded['result']);
        $this->assertArrayHasKey('account', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('balance', $responceDecoded['result'][0]);
    }

    public function testGetTransactions()
    {
        $response = $this->account->getTransactions($this->address, 1, 25, Account::SORT_ASC);
        $this->assertJson($response);
        $responseDecoded = json_decode($response, true);
        $this->assertArrayHasKey('status', $responseDecoded);
        $this->assertArrayHasKey('message', $responseDecoded);
        $this->assertArrayHasKey('result', $responseDecoded);

        $this->assertEquals('OK', $responseDecoded['message']);

        $this->assertInternalType('array', $responseDecoded['result']);
        $this->assertArrayHasKey(0, $responseDecoded['result']);
        $this->assertArrayHasKey('blockNumber', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('timeStamp', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('hash', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('nonce', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('blockHash', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('transactionIndex', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('from', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('to', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('value', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('gas', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('gasPrice', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('isError', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('input', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('contractAddress', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('cumulativeGasUsed', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('gasUsed', $responseDecoded['result'][0]);
        $this->assertArrayHasKey('confirmations', $responseDecoded['result'][0]);
    }
}
