<?php

namespace Tests\EtherScan\Modules;

use EtherScan\Modules\Logs;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

class LogsTest extends TestCase
{
    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';

    private $prefix = 'api.';

    private $conn;

    private $logs;

    private $address = '0xbb9bc244d798123fde783fcc1c72d3bb8c189413';

    private $getBalanceAsyncResponce = [
        'status'  => 1,
        'message' => 'OK',
        'result'  => '29336202160022049953',
    ];

    /**
     * LogsTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector($this->apiKey);
        $this->logs = new Logs($this->conn, $this->prefix);
    }

    public function testGetLogs()
    {
        $logs = $this->logs->getLogs($this->address);
        $this->assertJson($logs);
        $responceDecoded = json_decode($logs, true);

        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $log = $responceDecoded['result'][0];

        $this->assertArrayHasKey('address',$log);
        $this->assertArrayHasKey('topics',$log);
        $this->assertArrayHasKey('data',$log);
        $this->assertArrayHasKey('blockNumber',$log);
        $this->assertArrayHasKey('timeStamp',$log);
        $this->assertArrayHasKey('gasPrice',$log);
        $this->assertArrayHasKey('gasUsed',$log);
        $this->assertArrayHasKey('logIndex',$log);
        $this->assertArrayHasKey('transactionHash',$log);
        $this->assertArrayHasKey('transactionIndex',$log);
    }

    public function testGetLogsLink()
    {
        $link = $this->logs->getLogsLink($this->address);

        $this->assertEquals('https://api.etherscan.io/api?module=logs&action=getLogs&address=0xbb9bc244d798123fde783fcc1c72d3bb8c189413&fromBlock=0&toBlock=latest&apiKey=BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H', $link);
    }
}