# etherscan

<p>This lib is created for connecting to etherscan.io's api using php.</p>
<ul>
<li>sync

```
$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);


$account = $etherScan->getAccount(EtherScan::PREFIX_API);
$startT = microtime(1);
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
$endT = microtime(1);


echo "DONE IN: " . ($endT - $startT);
```

</li>
</ul>

</p>
