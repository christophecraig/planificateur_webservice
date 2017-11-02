<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

require_once 'controllers/DataController.class.php';
require_once 'connectors/DataRequest.class.php';
require_once 'TaskSelector.class.php';
require_once 'TaskCalculator.class.php';
require_once 'controllers/ResourceProcessing.class.php';

$dc = new DataController(new DataRequest());
$fac = Factory::getInstance(new DataRequest());

/*$projet = $dc->getDetailedProject("RadioFrancePro");
$dev = $dc->getDetailedDevelopment($projet['developments'][array_search("RadioFranceDev.1", $projet['developments'])]);*/
$projet = $dc->getDetailedProject("IIMPro");
$dev = $dc->getDetailedDevelopment($projet['developments'][array_search("IIMDev.1", $projet['developments'])]);

$resources = array();
$r = $dc->getResourcesWithSkill("PHP");
$i = 0;
foreach ($r as $ru) {
	$resources[$ru['id']] = $dc->getAResource($ru['id']);
	$i++;
}
// $nbRes = 2;
// var_dump($resources);

echo '<pre>';
var_dump($dc->getResources());
echo '</pre>';


// $result = TaskCalculator::calculateAverage($dev, TaskSelector::takeBestResourcesAverage($resources, 4));
// print "<br>Division par l'efficacite moyenne des meilleurs developpeurs : ".$result/(24*60*60);
// print "<br>D&eacute;but le ".date("Y-m-d", strtotime($dev["plannedStart"]));
// print "<br>Dur&eacute;e : ".date("z", $result)." jours";
// print "<br>Fin le ".date("Y-m-d", $result + strtotime($dev["plannedStart"]));

// $result = TaskCalculator::calculateAverage($dev, TaskSelector::takeWorstResourcesAverage($resources, 6));
// print "<br><br>Division par l'efficacite moyenne des moins bons developpeurs : ".$result/(24*60*60);
// print "<br>D&eacute;but le ".date("Y-m-d", strtotime($dev["plannedStart"]));
// print "<br>Dur&eacute;e : ".date("z", $result)." jours";
// print "<br>Fin le ".date("Y-m-d", $result + strtotime($dev["plannedStart"]));










$nbSkill = 2;
$arraySkill = array("PHP", "Scrum");
//var_dump(TaskSelector::takeWorstResourcesSkill($resources, 6, array("SQL")));
// $result = TaskCalculator::calculateWithSkillAverage($arraySkill, $dev, TaskSelector::takeBestResourcesSkill($resources, 4, $arraySkill));
// print "<br><br>Division par l'efficacite moyenne des competences en PHP et SQL des meilleurs developpeurs : ".$result/(24*60*60);
// print "<br>D&eacute;but le ".date("Y-m-d", strtotime($dev["plannedStart"]));
// print "<br>Dur&eacute;e : ".date("z", $result)." jours";
// print "<br>Fin le ".date("Y-m-d", $result + strtotime($dev["plannedStart"]));

/*$result = TaskCalculator::calculateWithSkillAverage($arraySkill, $projet, $dev, TaskSelector::takeWorstResourcesSkill($resources, 4, $arraySkill));
print "<br><br>Division par l'efficacite moyenne des competences en PHP et SQL des moins bons developpeurs : ".$result/(24*60*60);
print "<br>D&eacute;but le ".date("Y-m-d", strtotime($dev["plannedStart"]));
print "<br>Dur&eacute;e : ".date("z", $result)." jours";
print "<br>Fin le ".date("Y-m-d", $result + strtotime($dev["plannedStart"]));*/






print "<br>";
if (TaskCalculator::isHolidays($dev, $resources["ARenou"])) {
	print "C'est les vacances";
} else {
	print "C'est bon !";
}












// Demo heap sort
//var_dump(TaskSelector::take2BestResources($resources));
//var_dump(TaskSelector::take2WorstResources($resources));







//print_r($dc->getHolidays("VacARenou.1"));
//var_dump($dc->getAMind($dc->getACustomerMind($projet['customer'])['mind']));
