<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

require_once 'jsonRPCClient.php';

$client = new jsonRPCClient("http://192.168.0.80/~mbeacco/macro_planning/draft/test/ws.php");

$client->setFormatDate("D d M Y");

print $client->getDate();