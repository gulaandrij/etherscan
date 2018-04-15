<?php

namespace Tests\EtherScanTest\Modules;

use EtherScan\EtherScan;
use EtherScan\Modules\Stats;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsTest
 *
 * @package Tests\EtherScanTest\Modules
 */
class StatsTest extends TestCase
{

    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';

    private $prefix = 'api.';

    private $conn;

    private $stats;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector($this->apiKey);
        $this->stats = new Stats($this->conn, $this->prefix);
    }

    public function testGetEthPrice()
    {
        $responce = $this->stats->getEthPrice();
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
        $this->assertInternalType('array', $responceDecoded['result']);
        $this->assertArrayHasKey('ethbtc', $responceDecoded['result']);
        $this->assertArrayHasKey('ethbtc_timestamp', $responceDecoded['result']);
        $this->assertArrayHasKey('ethusd', $responceDecoded['result']);
        $this->assertArrayHasKey('ethusd_timestamp', $responceDecoded['result']);
    }

    public function testGetEthSupply()
    {
        $response = $this->stats->getEthSupply();
        $this->assertJson($response);
        $responseDecoded = json_decode($response, true);
        $this->assertArrayHasKey('status', $responseDecoded);
        $this->assertArrayHasKey('message', $responseDecoded);
        $this->assertArrayHasKey('result', $responseDecoded);

        $this->assertEquals('OK', $responseDecoded['message']);
        $floatResult = (float) $responseDecoded['result'];

        $this->assertInternalType('float', $floatResult);
    }
}
