<?php
require_once '../../lib/arc2/ARC2.php';
/**
 * @author mbeacco
 *
 */
class SPARQLConnector {
	
	/**
	 * Variable contenant le Store ARC2
	 * @var ARC2_Store
	 */
	public $store;
	
	/**
	 * Construit le store
	 */
	public function __construct() {
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
		$this->store = ARC2::getStoreEndpoint($config);
		
		if (!$this->store->isSetUp()) {
			$this->store->setUp(); /* create MySQL tables */
			$this->store->query('LOAD <http://localhost/~mbeacco/macro_planning/ontologie.xml>');
		}
		
		return $this->store;
	}
	
}