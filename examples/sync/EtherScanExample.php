<?php

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../../vendor/autoload.php';

$esApiConnector = new ApiConnector('BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H', EtherScan::MODE_API);

$etherScan = new EtherScan($esApiConnector);

$res = $etherScan->getStats()->getEthPrice();
echo "<pre>"; print_r($res); echo "</pre>"; die();

echo "hutul".PHP_EOL;
