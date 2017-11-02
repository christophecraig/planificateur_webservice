<?php
require_once 'lib/arc2/ARC2.php';

$config = array(
		/* db */
		'db_host' => 'localhost',
		'db_name' => 'planning',
		'db_user' => 'root',
		'db_pwd' => '',

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
$store = ARC2::getStoreEndpoint($config);

if (!$store->isSetUp()) {
	$store->setUp(); /* create MySQL tables */
	$store->query('LOAD <ontologie.xml>');
}