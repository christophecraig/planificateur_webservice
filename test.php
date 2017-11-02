<?php
$_ROOT = "http://localhost".getDir($_SERVER['PHP_SELF']);
$params = array("jsonrpc" => "2.0", "method" => "getPriorite", "params" => array(null), "id" => 1);
$defaults = array(
		CURLOPT_URL => $_ROOT.'index.php',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $params,
);
$ch = curl_init();
curl_setopt_array($ch, $defaults);

curl_exec($ch);

curl_close($ch);

function getDir($url) {
	$ch = explode('/', $url);
	$ch[sizeof($ch)-1] = "";
	$dir = implode('/', $ch);
	return $dir;
}
?>