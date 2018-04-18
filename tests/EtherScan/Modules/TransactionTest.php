<?php

namespace Tests\EtherScanTest\Modules;

use EtherScan\Modules\Transaction;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionTest
 * @package Tests\EtherScanTest\Modules
 */
class TransactionTest extends TestCase
{

    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';

    private $txhashSuccess = '0x334f4da8899b2cdb67893ae1794b22dc8433079c2ca4b135d7e8db230b34ad57';
    private $txhashError = '0x265784c4427768564a9d367e10449c4da9c3456954542301ef245b2bd5425c16';

    private $prefix = 'api.';

    private $transaction;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->transaction = new Transaction(new ApiConnector($this->apiKey), $this->prefix);
    }

    /**
     * @param string $txHash
     * @param int $error
     * @param int $status
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @dataProvider dataProvider
     */
    public function testGetExecutionStatus(string $txHash, int $error, int $status)
    {
        $json = $this->transaction->getExecutionStatus($txHash);

        $responseDecoded = json_decode($json, true);
        $this->assertArrayHasKey('status', $responseDecoded);
        $this->assertArrayHasKey('message', $responseDecoded);
        $this->assertArrayHasKey('result', $responseDecoded);
        $this->assertEquals($error, $responseDecoded['result']['isError']);
    }

    /**
     * @param string $txHash
     * @param int $error
     * @param int $status
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @dataProvider dataProvider
     */
    public function testGetReceiptStatus(string $txHash, int $error, int $status)
    {
        $json = $this->transaction->getReceiptStatus($txHash);

        $responseDecoded = json_decode($json, true);
        $this->assertArrayHasKey('status', $responseDecoded);
        $this->assertArrayHasKey('message', $responseDecoded);
        $this->assertArrayHasKey('result', $responseDecoded);
        $this->assertEquals($status, $responseDecoded['result']['status']);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [$this->txhashSuccess, 0, 1],
            [$this->txhashError, 1, 0],
        ];
    }
}
