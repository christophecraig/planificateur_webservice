<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

/*
 * Headers pour l'accès au web-service
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: content-type,x-requested-with");
header("Access-Control-Max-Age: 1728000");

// if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
// 	exit();
// }

require_once '../../../lib/JSON/jsonRPCServer.php';
require_once 'controllers/DataController.class.php';

$dc = new DataController(new DataRequest());

$j = new jsonRPCServer();

$query = file_get_contents("php://input");

$authorizedMethod = array(
		"getMinds",
		"getPriorities",
		"getCustomers",
		"getSkills",
		"getResources",
		"getAResource",
		"getProjects",
		"getListOfProjects",
		"getDetailedProject",
		"getDetailedDevelopment",
		"getSkillEfficiency",
		"getHolidays",
		"addProject",
		"addCustomer",
		"addResource",
		"addSkill",
		"addHolidays",
		"addSkillEfficiency",
		"addDevelopment",
		"addResourceToADevelopment",
		"addSkillToADevelopment"
		
);

$plop = $j->handle($dc, $authorizedMethod, json_decode($query,true));