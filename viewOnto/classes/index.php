<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

require_once '../../lib/h2o/h2o.php';
require_once 'controllers/OntologyController.class.php';

/* Commentaire pour le projet en lui-même
Toujours calculer "au plus tôt" et calculer les autres emplacements possibles
*/

/*function demoLookup($name,$context){
	
	return null;
}*/

/*function demo2Lookup($name,$context){
	var_dump("demo2",$name);
	
	switch ($name){
		case ':data.entity.babar' :
			return "plop";
	}
	return null;
}*/

//h2o::addLookup('demoLookup');
//h2o::addLookup('demo2Lookup');

if (isset($_GET['dataset'])) {
	$params = array(
			"object" => $_GET['value'],

	);
	$defaults = array(
			CURLOPT_URL => 'http://localhost/~mbeacco/macro_planning/viewOnto/classes/test.php',
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $params,
	);
	$ch = curl_init();
	$ok1 = curl_setopt_array($ch, $defaults);

	$ok2 = curl_exec($ch);

	$ok3 = curl_close($ch);
	
} else {

	$o = new OntologyController();
	$o->setOntology(new Ontology($o->bdd));
	
	
	if (!empty($_GET['type']) && !empty($_GET['value'])) {
		$demand = array(
			'type' => $_GET['type'],
			'value' => $_GET['value']
		);
		
		
	} else {
		$demand = array();
	}
	$o->getPage($demand);

}

?>