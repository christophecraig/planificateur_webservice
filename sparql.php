<?php
require_once 'lib/arc2/ARC2.php';
error_reporting(E_ALL);
ini_set("display_errors",1);

/* MySQL and endpoint configuration */
$config = array(
		/* db */
		'db_host' => '192.168.0.44',
		'db_name' => 'planning',
		'db_user' => 'root',
		'db_pwd' => 'root',
		
		'store_name' => 'planning',

		/* endpoint */
		'endpoint_features' => array(
				'select', 'construct', 'ask', 'describe',
				'load', 'insert', 'delete',
				'dump' /* dump is a special command for streaming SPOG export */
		),
		'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
		'endpoint_read_key' => '', /* optional */
		'endpoint_write_key' => '', /* optional, but without one, everyone can write! */
		'endpoint_max_limit' => 250, /* optional */
);

/* instantiation */
$ep = ARC2::getStoreEndpoint($config);

if (!$ep->isSetUp()) {
	$ep->setUp(); /* create MySQL tables */
	$ep->query('LOAD <ontologie.xml>');
}

/* request handling */
$ep->go();

?>