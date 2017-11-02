<?php
error_reporting(E_ALL);
ini_set("display_errors",1);


require_once '../../lib/JSON/jsonRPCServer.php';
require_once 'dataset/controllers/DataController.class.php';


// If no error...
if (!$notEnougthFile) {
	
	$control = new DataController(new DataRequest());
	$JsonServer = new jsonRPCServer();
	
}

if (isset($control)) {
	$temp['Client'] = $control->Client;
	$temp['Competence'] = $control->Competence;
	$temp['Developpement'] = $control->Developpement;
	$temp['Spirit'] = $control->Spirit;
	$temp['Priorite'] = $control->Priorite;
	$temp['Projet'] = $control->Projet;
	$temp['Ressource'] = $control->Ressource;
	
	$_SERVER['CONTENT_TYPE'] = 'application/json';
	$j1 = $JsonServer->handle($control, array("getArrayAsJson"), array("jsonrpc" => "2.0", "method" => "getArrayAsJson", "params" => array($temp[$_POST['object']]), "id" => 1));
	$j1 = json_decode($j1);
	$rendu['Result'] = $temp[$_POST['object']];
	$rendu['Links'] = array("Client", "Competence", "Developpement", "Priorite", "Projet", "Ressource", "Spirit");
	
	/*$o = new OntologyController();
	$o->setOntology(new Ontology($o->bdd));
	
	
	if (!empty($_GET['type']) && !empty($_GET['value']) && !empty($_GET['dataset'])) {
		$demand = array(
				'type' => $_GET['type'],
				'value' => $_GET['value'],
				'dataset' => $temp[$_POST['object']],
		);
	
	
	} else {
		$demand = array();
	}
	$o->getPage($demand);*/
	
	$h2o = new H2O('../templates/test.html', array("loader"=>'file'));
	echo $h2o->render($rendu);
} else {
	echo '<br>Pikachu attaque Fatal error !';
}
