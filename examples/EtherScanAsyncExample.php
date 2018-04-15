<?php

use EtherScan\EtherScan;
use EtherScan\Modules\Account;
use EtherScan\Resources\ApiConnector;

require __DIR__.'/../vendor/autoload.php';

$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);

$account = $etherScan->getAccount(EtherScan::PREFIX_API);
$startT = microtime(1);

$endT = microtime(1);

echo 'DONE IN: '.($endT - $startT);
