<?php

namespace Tests\EtherScanTest\Resources;

use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiConnectorTest
 *
 * @package Tests\EtherScanTest\Resources
 */
class ApiConnectorTest extends TestCase
{

    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';

    private $prefix = 'api.';

    private $conn;

    /**
     * ApiConnectorTest constructor.
     *
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector($this->apiKey);
    }

    public function testGenerateLink()
    {
        $responceUrl = 'https://api.etherscan.io/api?module=stats&action=ethprice&apiKey=BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';
        $resource = 'api';
        $queryParams = [
                        'module' => 'stats',
                        'action' => 'ethprice',
                       ];

        $this->assertInternalType('string', $resource);
        $this->assertInternalType('array', $queryParams);

        $url = $this->conn->generateLink($this->prefix, $resource, $queryParams);
        $this->assertEquals($responceUrl, $url);
    }

    public function testDoRequest()
    {
        $account = new \EtherScan\Modules\Account($this->conn, $this->prefix);
        $url = $account->getBalanceLink('0xbb9bc244d798123fde783fcc1c72d3bb8c189413');

        $responce = $this->conn->doRequest($url);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);

        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
    }
}
