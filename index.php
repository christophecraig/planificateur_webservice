<?php 
include 'connect_sparql.php';
include 'lib/JSON/jsonRPCServer.php';
include 'viewOnto/classes/dataset/models/Priority.class.php';

$JsonServer = new jsonRPCServer();

$prio1 = new Priority("Plop", 100);
$prio2 = new Priority("popol", 1);

$_SERVER['CONTENT_TYPE'] = 'application/json';
if (isset($_POST['id'])) {
	$j1 = $JsonServer->handle($prio1, array("getPriorite", "getNom"), array("jsonrpc" => $_POST['jsonrpc'], "method" => $_POST['method'], "params" => array(), "id" => $_POST['id']));
} else {
	$j1 = $JsonServer->handle($prio2, array("getPriorite", "getPoids", "getNom"), array("jsonrpc" => "2.0", "method" => "getPriorite", "params" => array(), "id" => 2));
}

$j11 = json_decode($j1);
echo $j11->result;
//var_dump($prio1, $prio2);
?>