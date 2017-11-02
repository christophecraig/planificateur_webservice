<?php

/*
 * CECI EST UNE PAGE DE TEST POUR L'ACCES AU WEB-SERVICE
 * ELLE N'EST DONC PAS A PRENDRE COMME PARTIE DE L'APPLICATION
 */

error_reporting(E_ALL);
ini_set("display_errors",1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: content-type,x-requested-with");
header("Access-Control-Max-Age: 1728000");

// if ($_SERVER["REQUEST_METHOD"]=="OPTIONS") exit();

require_once 'jsonRPCClient.php';
require_once 'Factory.class.php';
require_once 'connectors/DataRequest.class.php';

$client = new jsonRPCClient("http://192.168.0.80/~mbeacco/macro_planning/viewOnto/classes/dataset/ws-serv.php", true);

echo '<pre>';
print_r($client);
echo '</pre>';


/*********************************************************************************************************/
/*********************************************************************************************************/
/*********************************************************************************************************/


