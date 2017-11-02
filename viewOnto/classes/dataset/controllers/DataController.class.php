<?php
require_once './connectors/DataRequest.class.php';
require_once './models/Priority.class.php';
require_once './models/MindState.class.php';
require_once './models/Customer.class.php';
require_once './models/Skill.class.php';
require_once './models/Resource.class.php';
require_once './models/Development.class.php';
require_once './models/Project.class.php';
require_once 'ResourceProcessing.class.php';
require_once './Factory.class.php';
/**
 * @author mbeacco
 *
 */
class DataController {
	
	/**
	 * Contains the instance of DataRequest
	 * @var DataRequest
	 */
	private $bdd;
	
	private static $factory;
	
	/**
	 * This function build an instance of the data controller and fetch the database for the application's data
	 * @param DataRequest $bdd - An instance of DataRequest
	 */
	public function __construct($bdd) {
		$this->bdd = $bdd;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
	}
	
	/**
	 * @param DataRequest $bdd
	 */
	public function __wakeup() {
		$this->bdd = new DataRequest();
	}
	
	/**
	 * This function returns an array of resources
	 * @return array
	 */
	public function getResources() {
		$rows = self::$factory->getResourceId();
		$response = array();
		
		foreach ($rows as $resource) {
			$r = new Resource($resource['id'], $this->bdd);
			$r->setIdentity();
			$response[$r->getId()] = $r->getIdentity();
		}
		
		return $response;
	}
	
	/**
	 * If I want to have some informations about just one developer, I will use that
	 * @param string $id
	 * @return array
	 */
	public function getAResource($uri) {
		$r = new Resource($uri, $this->bdd);
		$r->setResource();
		return $r->getResource();
	}
	
	/**
	 * If I want to have some informations about just one developer, I will use that
	 * @param string $id
	 * @return array
	 */
	public function getResourcesWithSkill($skillUri) {
		$rows = self::$factory->getResourceId();
		$response = array();
		
		foreach ($rows as $resource) {
			$r = new Resource($resource['id'], $this->bdd);
			if ($r->resourceHaveSkill($skillUri)) {
				$r->setIdentity();
				$response[$r->getId()] = $r->getIdentity();
			}
			
		}
		
		return $response;
	}
	
	/**
	 * This function returns an array of clients
	 * @return array
	 */
	public function getCustomers() {
		$rows = self::$factory->getCustomerId();
		$response = array();
		
		foreach ($rows as $customer) {
			$c = new Customer($customer['id'], $this->bdd);
			$c->setCustomer();
			$response[$c->getId()] = $c->getCustomer();
		}
		
		return $response;
	}
	
	/**
	 * This function returns an array of skills
	 * @return array
	 */
	public function getSkills() {
		$rows = self::$factory->getSkillId();
		
		$response = array();
		foreach ($rows as $skill) {
			$s = new Skill($skill['id'], $this->bdd);
			$s->setSkill();
			$response[$s->getId()] = $s->getSkill();
		}
		return $response;
	}
	
	/**
	 * This function returns an array of project
	 * @param string
	 * @return array
	 */
	public function getDetailedProject($uri) {
		$p = new Project($uri, $this->bdd);
		$p->setDetails();
		return $p->getDetails();
	}
	
	/**
	 * This function returns an array of projects
	 * @return array
	 */
	public function getProjects() {
		$rows = self::$factory->getProjectId();
		
		$response = array();
		foreach ($rows as $project) {
			$p = new Project($project['id'], $this->bdd);
			$p->setDetails();
			$response[$project['id']] = $p->getDetails();
		}
		return $response;
	}
	
	/**
	 * @param string $uri
	 */
	public function getDetailedDevelopment($uri) {
		$p = new Development($uri, $this->bdd);
		$p->setDetails();
		return $p->getDetails();
	}	
	
	/**
	 * This function returns an array of projects for navigation headbang
	 * @return array
	 */
	public function getListOfProjects() {
		$rows = self::$factory->getProjectId();
		
		$response = array();
		foreach ($rows as $project) {
			$p = new Project($project['id'], $this->bdd);
			$p->setName();
			$response[$p->getId()] = $p->getName();
		}
		return $response;
	}
	
	/**
	 * This function returns an array of priorities
	 * @return array 
	 */
	public function getPriorities() {
		$rows = self::$factory->getWLId("Priority");
		
		$response = array();
		foreach ($rows as $priority) {
			$p = new Priority($priority['id'], $this->bdd);
			$p->setPriority();
			$response[$p->getId()] = $p->getPriority();
		}
		return $response;
	}
	
	/**
	 * This function returns an array of priorities
	 * @return array 
	 */
	public function getAPriority($uri) {
		$p = new Priority($uri, $this->bdd);
		$p->setPriority();
		return $p->getPriority();
	}
	
	/**
	 * This function returns an array of spirits
	 * @return array 
	 */
	public function getMinds() {
		$rows = self::$factory->getWLId("MindState");
		
		$response = array();
		foreach ($rows as $minds) {
			$mS = new MindState($minds['id'], $this->bdd);
			$mS->setMindState();
			$response[$mS->getId()] = $mS->getMindState();
		}
		return $response;
	}
	
	/**
	 * This function returns an array of priorities
	 * @return array 
	 */
	public function getAMind($uri) {
		$p = new MindState($uri, $this->bdd);
		$p->setMindState();
		return $p->getMindState();
	}
	
	/**
	 * If I want to have some informations about just one developer, I will use that
	 * @param string $id
	 * @return array
	 */
	public function getACustomerMind($uri) {
		$r = new CustomerMind($uri, $this->bdd);
		$r->setCustomerMind();
		return $r->getCustomerMind();
	}
	
	/**
	 * This function return a description of a skill efficiency
	 * @param string $id
	 * @return array 
	 */
	public function getSkillEfficiency($id) {
		$sE = new SkillEfficiency($id, $this->bdd);
		$sE->setSkillEfficiency();
		return $sE->getSkillEfficiency();
	}
	
	/**
	 * This function returns a description of an holidays period
	 * @return array 
	 */
	public function getHolidays($id) {
		$h = new Holidays($id, $this->bdd);
		$h->setHolidays();
		return $h->getHolidays();
	}
	
	/**
	 * Use this to add a project
	 * @param array $projectContent
	 * @return boolean
	 */
	public function addProject($projectContent) {
		$option = array();
		
		if (isset($projectContent['id'])) {
			$id = $projectContent['id'].'Pro';
		} else {
			if (isset($projectContent['name'])) {
				$tabTemp = explode(" ", $projectContent['name']);
				$temp = implode("", $tabTemp);
				$id = $temp.'Pro';
			} else {
				$id = "Project_ID.1";
			}
		}
		
		if (isset($projectContent['name'])) {
			$option['name'] = $projectContent['name'];
		} else {
			$option['name'] = "No name";
		}
		
		if (isset($projectContent['priority'])) {
			$option['priority'] = $projectContent['priority'];
		} else {	
			$option['priority'] = "PrioNormale";
		}
		
		if (isset($projectContent['customerMind'])) {
			if (isset($projectContent['customerMind']['customer'])) {
				if (isset($projectContent['customerMind']['mind'])) {
					$o = array(
							"customer" => $projectContent['customerMind']['customer'],
							"mind" => $projectContent['customerMind']['mind'],
					);
					$cm = new CustomerMind($projectContent['customerMind']['customer'].$id."MS", $this->bdd, $o);
					$this->bdd->insertCustomerMind($cm->getCustomerMind());
					$option['customer'] = $cm->getCustomerMind()['id'];
				} else {
					$option['customer'] = $projectContent['customerMind']['client'];
				}
			} else {
				$option['customer'] = "DefaultCusMS";
			}
		} else {
			$option['customer'] = "DefaultCusMS";
		}
		
		if (isset($projectContent['developersMind'])) {
			$option['developersMind'] = $projectContent['developersMind'];
		} else {
			$option['developersMind'] = "Moy";
		}
		
		$newProject = new Project($id, $this->bdd, $option);
		
		$this->bdd->insertProject($newProject->getDetails());
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		self::$factory->getProjectId();
		
		return true;
		
	}
	
	/**
	 * Use this to add a customer
	 * @param array $customerContent
	 * @return boolean
	 */
	public function addCustomer($customerContent) {
		if (isset($customerContent['id'])) {
			$id = $customerContent['id']."Cus";
		} else {
			if (isset($customerContent['name'])) {
				$tabTemp = explode(" ", $customerContent['name']);
				$temp = implode("", $tabTemp);
				$id = $temp.'Cus';
			} else {
				$id = "PirateNoId";
			}
		}
		
		if (isset($customerContent['name'])) {
			$name = $customerContent['name'];
		} else {
			$name = "Barbosa";
		}
		
		if (isset($customerContent['firstName'])) {
			$fName = $customerContent['firstName'];
		} else {
			$fName = "Hector";
		}
		
		$option = array(
				"name" => $name,
				"firstName" => $fName,
		);
		
		$newCustomer = new Customer($id, $this->bdd, $option);
		
		$this->bdd->insertCustomer($newCustomer->getCustomer());
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		self::$factory->getCustomerId();
		
		return true;
		
	}
	
	/**
	 * Use this to add a resource
	 * @param array $resourceContent
	 * @return boolean
	 */
	public function addResource($resourceContent) {
		if (isset($resourceContent['id'])) {
			$id = $resourceContent['id']."";
		} else {
			if (isset($resourceContent['name'])) {
				$tabTemp = explode(" ", $resourceContent['name']);
				$temp = implode("", $tabTemp);
				$id = $temp;
			} else {
				$id = "PirateNoId";
			}
		}
		
		if (isset($resourceContent['name'])) {
			$name = $resourceContent['name'];
		} else {
			$name = "Sparrow";
		}
		
		if (isset($resourceContent['firstName'])) {
			$fName = $resourceContent['firstName'];
		} else {
			$fName = "Jack";
		}
		
		$option = array(
				"name" => $name,
				"firstName" => $fName,
		);
		
		$newResource = new Resource($id, $this->bdd, $option);
		
		$this->bdd->insertResource($newResource->getResource());
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
 		self::$factory->getResourceId();
		
		return true;
	}
	
	/**
	 * Use this to add a skill
	 * @param array $skillContent
	 * @return boolean
	 */
	public function addSkill($skillContent) {
		if (isset($skillContent['id'])) {
			$id = $skillContent['id'];
		} else {
			if (isset($skillContent['name'])) {
				$tabTemp = explode(" ", $skillContent['name']);
				$temp = implode("", $tabTemp);
				$id = $temp;
			} else {
				$id = "SkillNoId";
			}
		}
		
		if (isset($skillContent['name'])) {
			$name = $skillContent['name'];
		} else {
			$name = "No name";
		}
		
		if (isset($skillContent['parent'])) {
			$parent = $this->Skills[$skillContent['parent']];
		} else {
			$parent = null;
		}
		
		$option = array(
				"name" => $name,
				"parent" => $parent,
		);
		
		$newSkill = new Skill($id, $this->bdd, $option);
		
		$this->bdd->insertSkill($newSkill->getSkill());
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		self::$factory->getSkillId();
		
		return true;
	}
	
	/**
	 * Use this to add an holidays period to a resource
	 * @param array $holidaysContent
	 * @return boolean
	 */
	public function addHolidays($holidaysContent) {
		$paris = new DateTimeZone("Europe/Paris");
		
		if (isset($holidaysContent['id'])) {
			$id = $holidaysContent['id'];
		} else {
			$id = "Holidays";
		}
		
		if (isset($holidaysContent['begin'])) {
			$d = ResourceProcessing::dateFRtoUS($holidaysContent['begin']);
		} else {
			$d = date("Y-m-d");
		}
		
		if (isset($holidaysContent['end'])) {
			$f = ResourceProcessing::dateFRtoUS($holidaysContent['end']);
		} else {
			$f = date("Y-m-d");
		}
		
		if (isset($holidaysContent['why'])) {
			$why = $holidaysContent['why'];
		} else {
			$why = "";
		}
		
		$option = array(
				"begin" => $d,
				"end" => $f,
				"why" => $why,
		);
		
		$newHolidays = new Holidays($id, $this->bdd, $option);
		
		$insertion = array(
				"resourceId" => $holidaysContent['resource'],
				"holidays" => $newHolidays->getHolidays(),
		);
		
		$this->bdd->insertHolidays($insertion);
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		return true;
	}
	
	/**
	 * Use this to add a skill efficiency to a resource
	 * @param array $skillEfficiencyContent
	 * @return boolean
	 */
	public function addSkillEfficiency($skillEfficiencyContent) {
		
		if (isset($skillEfficiencyContent['id'])) {
			$id = $skillEfficiencyContent['id'];
		} else {
			$id = "SkillEfficiencyNoId";
		}
		
		if (isset($skillEfficiencyContent['skill'])) {
			$skill =$skillEfficiencyContent['skill'];
		} else {
			$skill = "PHP";
		}
		
		if (isset($skillEfficiencyContent['efficiency'])) {
			$eff = $skillEfficiencyContent['efficiency'];
		} else {
			$eff = 0.5;
		}
		
		$option = array(
				"skill" => $skill,
				"efficiency" => $eff,
		);
		
		$newSkillEfficiency = new SkillEfficiency($id, $this->bdd, $option);
		
		$insertion = array(
				"resourceId" => $skillEfficiencyContent['resource'],
				"skillEfficiency" => $newSkillEfficiency->getSkillEfficiency(),
		);
		
		$this->bdd->insertSkillEfficiency($insertion);
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		return true;
	}
	
	/**
	 * You want to add a development, use this method.
	 * @param array $developmentContent
	 * @return boolean
	 */
	public function addDevelopment($developmentContent) {
		if (isset($developmentContent['id'])) {
			if (preg_match("#Dev#", $developmentContent['id'])) {
				if (strlen($developmentContent['id']) - strlen("Dev") != strpos($developmentContent['id'], "Dev")) {
					str_replace("Dev", "", $developmentContent['id']);
					$developmentContent['id'] .= "Dev";
				}
			} else {
				$developmentContent['id'] .= "Dev";
			}
			
			$id = $developmentContent['id'];
		} else {
			
		}
		
		if (isset($developmentContent['name'])) {
			$name = $developmentContent['name'];
		} else {
			$name = "No name";
		}
		
		if (isset($developmentContent['priority'])) {
			$priority = $developmentContent['priority'];
		} else {
			$priority = NULL;
		}
		
		if (isset($developmentContent['plannedStart'])) {
			$plannedStart = ResourceProcessing::dateFRtoUS($developmentContent['plannedStart']);
		} else {
			$plannedStart = NULL;
		}
		
		if (isset($developmentContent['plannedEnd'])) {
			$plannedEnd = ResourceProcessing::dateFRtoUS($developmentContent['plannedEnd']);
		} else {
			$plannedEnd = NULL;	
		}
		
		if (isset($developmentContent['realStart'])) {
			$realStart = ResourceProcessing::dateFRtoUS($developmentContent['realStart']);
		} else {
			$realStart = $plannedStart;
		}
		
		if (isset($developmentContent['realEnd'])) {
			$realEnd = ResourceProcessing::dateFRtoUS($developmentContent['realEnd']);
		} else {
			$realEnd = $plannedEnd;
		}
		
		if (isset($developmentContent['earlyStart'])) {
			$earlyStart = ResourceProcessing::dateFRtoUS($developmentContent['earlyStart']);
		} else {
			$earlyStart = $plannedStart;
		}
		
		if (isset($developmentContent['earlyEnd'])) {
			$earlyEnd = ResourceProcessing::dateFRtoUS($developmentContent['earlyEnd']);
		} else {
			$earlyEnd = $plannedEnd;
		}
		
		if (isset($developmentContent['lateStart'])) {
			$lateStart = ResourceProcessing::dateFRtoUS($developmentContent['lateStart']);
		} else {
			$lateStart = $plannedStart;
		}
		
		if (isset($developmentContent['lateEnd'])) {
			$lateEnd = ResourceProcessing::dateFRtoUS($developmentContent['lateEnd']);
		} else {
			$lateEnd = $plannedEnd;
		}
		
		if (isset($developmentContent['duration'])) {
			$duration = $developmentContent['duration'];
		} else {
			$duration = 0;
		}
		
		if (isset($developmentContent['effort'])) {
			$effort = $developmentContent['effort'];
		} else {
			$effort = 0;
		}
		
		if (isset($developmentContent['status'])) {
			$status = $developmentContent['status'];
		} else {
			$status = 0;
		}
		
		if (isset($developmentContent['optional'])) {
			$optional = $developmentContent['optional'];
		} else {
			$optionnal = "false";
		}
		
		if (isset($developmentContent['parentDevelopment'])) {
			$parentDevelopment = $developmentContent['parentDevelopment'];
		} else {
			$parentDevelopment = NULL;
		}
		
		if (isset($developmentContent['previousDevelopment'])) {
			$previousDevelopment = $developmentContent['previousDevelopment'];
		} else {
			$previousDevelopment = NULL;
		}
		
		$option = array(
				"name" => $name,
				"duration" => $duration,
				"earlyStart" => $earlyStart,
				"lateStart" => $lateStart,
				"realStart" => $realStart,
				"plannedStart" => $plannedStart,
				"earlyEnd" => $earlyEnd,
				"lateEnd" => $lateEnd,
				"realEnd" => $realEnd,
				"plannedEnd" => $plannedEnd,
				"priority" => $priority,
				"status" => $status,
				"optional" => $optional,
				"parentDevelopment" => $parentDevelopment,
				"previousDevelopment" => $previousDevelopment,
				"effort" => $effort,
		);
		
		$newDevelopment = new Development($id, $this->bdd, $option);
		
		$insertion = $newDevelopment->getDetails();
		$insertion['projectId'] = $developmentContent['project'];
		
		
		$this->bdd->insertDevelopment($insertion);
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		self::$factory->getDevelopmentId();
		
		return true;
	}
	
	/**
	 * A developer want to work ? Affect him to a development
	 * @param string $whatILink
	 * @return boolean
	 */
	public function addResourceToADevelopment($whatILink) {
		$insertion = array(
				"resourceID" => $whatILink['resourceID'],
				"developmentID" => $whatILink['developmentID'],
		);
		
		$this->bdd->affectAResource($insertion);
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		return true;
	}
	
	/**
	 * Not really interesting, just to tag a development with a skill
	 * @param array $whatILink
	 * @return boolean
	 */
	public function addSkillToADevelopment($whatILink) {
		$insertion = array(
				"skillID" => $whatILink['skillID'],
				"developmentID" => $whatILink['developmentID'],
		);
		
		$this->bdd->tagADevelopment($insertion);
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		return true;
	}
	
}