<?php

/*
 * CECI EST UNE PAGE DE TEST POUR L'ACCES AU WEB-SERVICE
 * ELLE N'EST DONC PAS A PRENDRE COMME PARTIE DE L'APPLICATION
 */

error_reporting(E_ALL);
ini_set("display_errors",1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: content-type,x-requested-with");
header("Access-Control-Max-Age: 1728000");

if ($_SERVER["REQUEST_METHOD"]=="OPTIONS") exit();

require_once 'jsonRPCClient.php';
require_once 'Factory.class.php';
require_once 'connectors/DataRequest.class.php';

//$client = new jsonRPCClient("/run/media/mbeacco/64Go_USB3.0/STAGE/pmb/macro_planning/viewOnto/classes/dataset/ws-serv.php", true);
$client = new jsonRPCClient("http://192.168.0.50/~ccraig/macro_planning/viewOnto/classes/dataset/ws-serv.php", true);

//print "<h1>C'est légèrement plus lent à cause d'une tempo de 0.25 seconde. Les appels fopen devait être trop rapprochés et c'est sans doute ça qui faisait planter la page.</h1><br>";
print '<br><h3>Fonction "getMinds() : array" | Renvoie la description de tout les &eacute;tats d\'esprit possibles (utile pour un filtre par exemple)</h3>';
try { $client->getMinds(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getPriorities() : array" | Renvoie la description de toutes les priorit&eacute;s possibles (utile pour un filtre par exemple)</h3>';
try { $client->getPriorities(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getProjects() : array" | Renvoie la description de tout les projets</h3>';
try { $client->getProjects(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getListOfProjects() : array" | Renvoie seulement les nom et  les ID des projets pour le bandeau horizontal</h3>';
try { $client->getListOfProjects(); } catch (Exception $e) { $e->getTrace(); } // horizontal list



print '<br><hr><br><h3>Fonction "getDetailedProject($idProjet : string) : array" | Renvoie la description d\'un projet (pour que ce soit plus facilement manipulable que toute la structure)</h3>';
try { $client->getDetailedProject('IIMPro'); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getAResource($idResource : string) : array" | Renvoie la description d\'une ressource</h3>';
try { $client->getAResource('ARenou'); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getResources() : array" | Renvoie la description de toutes les ressources</h3>';
try { $client->getResources(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getSkills() : array" | Renvoie la description de toutes les comp&eacute;tences</h3>';
try { $client->getSkills(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getCustomers() : array" | Renvoie la description de tout les clients</h3>';
try { $client->getCustomers(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getDetailedDevelopment(id : string) : array" | Renvoie la description d\'un development avec son id</h3>';
try { $client->getDetailedDevelopment("IIMDev.2.2"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getSkillEfficiency(id : string) : array" | Renvoie la description d\'une efficacité de compétence avec son id</h3>';
try { $client->getSkillEfficiency("SparqlARenou"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "getHolidays(id : string) : array" | Renvoie la description d\'une période de vacances avec son id</h3>';
try { $client->getHolidays("VacARenou.1"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addProject(array("id" : string, "name" : string, "priority[ID]" : string, "customerSpirit" : array("client[ID]" : string, "spirit[ID]" : string), "developersSpirit[ID]": string)) : boolean" | Ajoute un projet avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addProject(array(
		"id" => "trotro",
		"name" => "tename",
		"priority" => "PrioHaute",
		"customerMind" => array(
				"customer" => "PMBCus",
				"mind" => "Bon",
		),
		"developersMind" => "Bon",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedProject("trotroPro"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addCustomer(array("id" : string, "name" : string, "firstName" : string)) : boolean" | Ajoute un client avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addCustomer(array(
		"id" => "ANGP",
		"name" => "TERRIEUR",
		"firstName" => "Alex",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getCustomers(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addResource(array("id" : string, "name" : string, "firstName" : string)) : boolean" | Ajoute une ressource avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addResource(array(
		"id" => "ATerrieur",
		"name" => "TERRIEUR",
		"firstName" => "Alex",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getResources(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addSkill(array("id" : string, "name" : string, "parent[ID]" : string)) : boolean" | Ajoute une comp&eacute;tence avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addSkill(array(
		"id" => "Yolo2",
		"name" => "yolo2",
		"parent" => "PHP",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getSkills(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addHolidays(array("id" : string, "begin[yyyy-mm-dd]" : string, "end[yyyy-mm-dd]" : string, "why" : string, "resource[ID]" : string)) : boolean" | Ajoute une p&eacute;riode de vacances &agrave; une ressource avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addHolidays(array(
		"id" => "Vacances2",
		"resource" => "VTouchard",
		"begin" => "2017-05-02",
		"end" => "2017-05-05",
		"why" => "JE VAIS CRAMER TRUUUUUUUUUUUUMP",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getAResource('VTouchard'); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getHolidays('Vacances2'); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addSkillEfficiency(array("id" : string, "skill[ID]" : string, "efficiency" : float, "resource[ID]" : string)) : boolean" | Ajoute une efficacit&eacute; de comp&eacute;tence &agrave; une ressource avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addSkillEfficiency(array(
 		"id" => "DojoDGoron",
 		"resource" => "DGoron",
 		"skill" => "Dojo",
 		"efficiency" => 0.75,
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getAResource("DGoron"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addDevelopment(array("id" : string, "name" : string, "earlyStart" : string, "lateStart" : string, "realStart" : string, "plannedStart" : string, "earlyEnd" : string, "lateEnd" : string, "realEnd" : string, "plannedEnd" : string, "priority" : string, "status" : integer, "optional" : string[<b>true</b> or <b>false</b>], "effort" : integer, "project" : string[projectId]) : boolean" | Ajoute un d&eacute;veloppement avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addDevelopment(array(
		"id" => "Test",
		"name" => "Yolo",
		"earlyStart" => "04/05/2017",
		"lateStart" => "09/05/2017",
		"realStart" => "05/05/2017",
		"plannedStart" => "04/05/2017",
		"earlyEnd" => "02/06/2017",
		"lateEnd" => "31/08/2017",
		"realEnd" => "15/08/2017",
		"plannedEnd" => "02/06/2017",
		"priority" => "PrioHaute",
		"status" => 0,
		"optional" => "false",
		"effort" => 0,
		"project" => "IIMPro"
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedProject('IIMPro'); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedDevelopment('TestDev'); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addResourceToADevelopment(array("resourceID" : string, "developmentID]" : string) : boolean" | Ajoute une efficacit&eacute; de comp&eacute;tence &agrave; une ressource avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addResourceToADevelopment(array(
		"resourceID" => "DGoron",
		"developmentID" => "TestDev",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedDevelopment('TestDev'); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "addSkillToADevelopment(array("skillID" : string, "developmentID]" : string) : boolean" | Ajoute une efficacit&eacute; de comp&eacute;tence &agrave; une ressource avec le contenu du tableau pass&eacute; en param&egrave;tre</h3>';
try { $client->addSkillToADevelopment(array(
		"skillID" => "PHP",
		"developmentID" => "TestDev",
)); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedDevelopment('TestDev'); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "deleteSometing(string : $uri, string : $propertie) : boolean" | Supprime toute ou partie des propri&eacute;t&eacute;s associ&eacute;es à l\'URI pass&eacute;e en param&egrave;tre </h3>';
// try { $client->deleteSomething("Vue.js", "parentSkill"); } catch (Exception $e) { $e->getTrace(); }
// try { $client->deleteSomething("Yolo2", "id"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getSkills(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifySkill(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie la comp&eacute;tence </h3>';
try { $client->modifySkill("Java", "name","Wesh papy"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifySkill("Java", "parentSkill","HTML"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getSkills(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyPriority(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie la priorit&eacute; </h3>';
try { $client->modifyPriority("PrioBasse", "name","Trololol"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyPriority("PrioHaute", "weight","4"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getPriorities(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyMindState(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie l&eacute;tat d\'esprit</h3>';
try { $client->modifyMindstate("Bon", "name","Plop"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyMindState("Moy", "weight","5"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getMinds(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyResource(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie la ressource </h3>';
try { $client->modifyResource("ATerrieur", "name","Plop"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyResource("ATerrieur", "firstName","Bob"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyResource("ATerrieur", "baseEfficiency","45"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getAResource("ATerrieur"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyProject(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie le projet </h3>';
try { $client->modifyProject("IIMPro", "name","Yolo"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyProject("IIMPro", "customer","ANGPCli"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyProject("IIMPro", "priority","PrioBasse"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyProject("IIMPro", "developersMind","Cata"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedProject("IIMPro"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyHolidays(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie la p&eacute;riode de vacances<br>';
print "Les dates sont en format aaaa-mm-jj</h3>";
try { $client->modifyHolidays("Vacances2", "start","2017-06-02"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyHolidays("Vacances2", "end","2017-09-05"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyHolidays("Vacances2", "reason","The floor is Microsoft"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getHolidays("Vacances2"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyCustomer(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie le client</h3>';
try { $client->modifyCustomer("ANGPCus", "name", "Kisekela"); } catch (Exception $e) { $e->getTrace(); }
try { $client->modifyCustomer("ANGPCus", "firstname", "Imatoumi"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getCustomers(); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifySkillEfficiency(string : $uri, string : $newValue) : boolean" | Modifie l\'efficacit&eacute; d\'une comp&eacute;tence</h3>';
try { $client->modifySkillEfficiency("DojoDGoron", "45"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getAResource("DGoron"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyCustomerMind(string : $uri, string : $newValue) : boolean" | Modifie l\'etat d\'esprit d\'un client</h3>';
try { $client->modifyCustomerMind("PMBCusMS", "Cata"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getACustomerMind("PMBCusMS"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "modifyDevelopment(string : $uri, string : $propertie, string : $newValue) : boolean" | Modifie un dev</h3>';
try { $client->modifyDevelopment("TestDev", "previousDevelopment", "NumilogDev"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedDevelopment("TestDev"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "removeHolidaysFromResource(string : $hID, string : $rID) : boolean" | Enl&egrave;ve une p&eacute;riode de vacances</h3>';
try { $client->removeHolidaysFromResource("VacARenou.1", "ARenou"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getAResource("ARenou"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "removeSkillEfficiencyFromResource(string : $rID, string : $seID) : boolean" | Enl&egrave;ve une efficacit&eacute; de comp&eacute;tence &agrave; une ressource</h3>';
try { $client->removeSkillEfficiencyFromResource("ARenou", "PhpARenou"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getAResource("ARenou"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "removeDevelopmentFromProject(string : $pID, string : $dID) : boolean" | Enl&egrave;ve un dev d\'un projet</h3>';
try { $client->removeDevelopmentFromProject("NumilogPro", "NumilogDev"); } catch (Exception $e) { $e->getTrace(); }
print '<br>';
try { $client->getDetailedProject("NumilogPro"); } catch (Exception $e) { $e->getTrace(); }



print '<br><hr><br><h3>Fonction "giveMeSomePossibilities(array : $dev, integer : $nbRes, string : $order, string : $periodEnd, string : $periodStart, array : $skill) : array" | Calcule les emplacement possibles pour un d&eacute;veloppement</h3>';
try { $dev = $client->getDetailedDevelopment("RadioFranceDev.1"); } catch (Exception $e) { $e->getTrace(); }
try { $client->giveMeSomePossibilities($dev, 1, "Best"); } catch (Exception $e) { $e->getTrace(); }

// print '<br><br><img alt="Mes hommages..." src="../../../draft/pirate_bay.gif"><br>';


/*********************************************************************************************************/
/*********************************************************************************************************/
/*********************************************************************************************************/
