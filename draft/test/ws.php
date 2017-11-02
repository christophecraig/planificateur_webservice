<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: content-type,x-requested-with");
header("Access-Control-Max-Age: 1728000");

if ($_SERVER["REQUEST_METHOD"]=="OPTIONS") exit();

require_once 'Horloge.class.php'; //controlleur
require_once 'jsonRPCServer.php';

if (file_exists("horloge.txt")) {
	$h = unserialize(file_get_contents("horloge.txt"));
} else {
	$h = new Horloge("d/m/Y", "H:i:s");
}
	
$j = new jsonRPCServer();

$query = file_get_contents("php://input");
//echo $query;


$plop = $j->handle($h, array("getDate", "getHeure", "setFormatDate", "setFormatHeure"), json_decode($query,true));
if ($h) {
	file_put_contents("horloge.txt", serialize($h));
}
//file_put_contents("horloge.txt", serialize($h));
//echo 'plop';
