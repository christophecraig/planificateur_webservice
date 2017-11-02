<?php
require_once 'controllers/ResourceProcessing.class.php';

class Factory {
	
	private static $Resource = array();
	private static $Development = array();
	private static $Project = array();
	private static $CustomerMind = array();
	private static $WeightedList = array();
	private static $Holidays = array();
	private static $SkillEfficiency = array();
	private static $Customer = array();
	private static $Skill = array();
	
	/**
	 * @var Factory
	 */
	private static $instance;
	
	/**
	 *
	 * @var DataRequest
	 */
	private static $bdd;
	
	/**
	 * Construct the factory
	 * @param DataRequest $bdd
	 */
	private function __construct($bdd) {
		self::$bdd = $bdd;
		
		if (file_exists("Factory.tmp.txt")) {
			$unserializeArray = unserialize(file_get_contents("Factory.tmp.txt"));
			
			if ((time() - $unserializeArray["time"]) <= 60) {
				Factory::$Resource = $unserializeArray["Resource"];
				Factory::$Development = $unserializeArray["Development"];
				Factory::$Project = $unserializeArray["Project"];
				Factory::$Skill = $unserializeArray["Skill"];
				Factory::$WeightedList = $unserializeArray["WeightedList"];
				Factory::$Holidays = $unserializeArray["Holidays"];
				Factory::$SkillEfficiency = $unserializeArray["SkillEfficiency"];
				Factory::$Customer = $unserializeArray["Customer"];
				Factory::$CustomerMind = $unserializeArray["CustomerMind"];
			} else {
				unlink("Factory.tmp.txt");
			}
			
		}
	}
	
	/**
	 * Save all data
	 */
	public function save() {
		if (file_exists("Factory.tmp.txt")) {
			unlink("Factory.tmp.txt");
		}
		
		file_put_contents("Factory.tmp.txt", serialize(array(
				"Resource" => Factory::$Resource,
				"Development" => Factory::$Development,
				"Project" => Factory::$Project,
				"Skill" => Factory::$Skill,
				"WeightedList" => Factory::$WeightedList,
				"Holidays" => Factory::$Holidays,
				"SkillEfficiency" => Factory::$SkillEfficiency,
				"Customer" => Factory::$Customer,
				"CustomerMind" => Factory::$CustomerMind,
				"time" => time()
		)));
	}
	
	/**
	 * @param DataRequest $bdd
	 * @return Factory
	 */
	public static function getInstance($bdd) {
		if (!isset(self::$instance)) {
			self::$instance = new Factory($bdd);
		}
		
		return self::$instance;
	}
	
	
	
	// Project
	/**
	 * @return array
	 */
	public function getProjectId() {
		$rows = self::$bdd->getListOfUri("Project");
		
		if (sizeof($rows) != sizeof(self::$Project)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$Project[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		
		return self::$Project;
		
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectName($uri) {
		if (!isset(self::$Project[$uri]['name'])) {
			$rows = self::$bdd->getLabel($uri);
			
			if (isset($rows[0]['l'])) {
				self::$Project[$uri]['name'] = ResourceProcessing::withoutURL($rows[0]['l']);
			} else {
				self::$Project[$uri]['name'] = null;
			}
		
			$this->save();
		}
		
		return self::$Project[$uri]['name'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectPriority($uri) {
		if (!isset(self::$Project[$uri]['priority'])) {
			$rows = self::$bdd->getPriority($uri);
			
			if (isset($rows[0]['p'])) {
				self::$Project[$uri]['priority'] = ResourceProcessing::withoutURL($rows[0]['p']);
			} else {
				self::$Project[$uri]['priority'] = null;
			}	
		
			$this->save();
		}
		
		return self::$Project[$uri]['priority'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectCustomer($uri) {
		if (!isset(self::$Project[$uri]['customer'])) {
			$rows = self::$bdd->getProjectCustomer($uri);
			
			if (isset($rows[0]['c'])) {
				self::$Project[$uri]['customer'] = ResourceProcessing::withoutURL($rows[0]['c']);
			} else {
				self::$Project[$uri]['customer'] = null;
			}	
		
			$this->save();
		}
		
		return self::$Project[$uri]['customer'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectDevelopersMind($uri) {
		if (!isset(self::$Project[$uri]['developersMind'])) {
			$rows = self::$bdd->getProjectDevelopersMind($uri);
			
			if (isset($rows[0]['dM'])) {
				self::$Project[$uri]['developersMind'] = ResourceProcessing::withoutURL($rows[0]['dM']);
			} else {
				self::$Project[$uri]['developersMind'] = null;
			}	
		
			$this->save();
		}
		
		return self::$Project[$uri]['developersMind'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectDevelopments($uri) {
		if (!isset(self::$Project[$uri]['developments'])) {
			$rows = self::$bdd->getProjectDevelopments($uri);
			
			if (!empty($rows)) {
				for ($i = 0; $i < sizeof($rows); $i++) {
					self::$Project[$uri]['developments'][$i] = ResourceProcessing::withoutURL($rows[$i]['d']);
				}
			} else {
				self::$Project[$uri]['developments'][0] = "No developments";
			}	
		
			$this->save();
		}
		
		return self::$Project[$uri]['developments'];
	}
	
	
	
	// Weighted List
	/**
	 * Get weighted list id by the $type
	 * @param string $type
	 * @return array
	 */
	public function getWLId($type) {
		$rows = self::$bdd->getListOfUri($type);
		
		if (sizeof($rows) != sizeof(self::$WeightedList)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$WeightedList[$type][ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s']),
				);
			}
			
			$this->save();
		}
		
		return self::$WeightedList[$type];
	}
	
	/**
	 * Get weighted list item name
	 * @param string $uri
	 */
	public function getWLName($uri) {
		if (!isset(self::$WeightedList[$uri]['name'])) {
			$rows = self::$bdd->getLabel($uri);
			
			if (isset($rows[0]['l'])) {
				self::$WeightedList[$uri]['name'] = ResourceProcessing::withoutURL($rows[0]['l']);
			} else {
				self::$WeightedList[$uri]['name'] = null;
			}
			
			$this->save();
		}
		
		return self::$WeightedList[$uri]['name'];
	}
	
	/**
	 * Get weighted list item weight
	 * @param string $uri
	 */
	public function getWLWeight($uri) {
		if (!isset(self::$WeightedList[$uri]['weight'])) {
			$rows = self::$bdd->getWLWeight($uri);
				
			if (isset($rows[0]['w'])) {
				self::$WeightedList[$uri]['weight'] = ResourceProcessing::withoutURL($rows[0]['w']);
			} else {
				self::$WeightedList[$uri]['weight'] = null;
			}
				
			$this->save();
		}
		
		return self::$WeightedList[$uri]['weight'];
	}
	
	
	
	//Skills
	/**
	 * @return array
	 */
	public function getSkillId() {
		$rows = self::$bdd->getListOfUri("Skill");
		
		if (sizeof($rows) != sizeof(self::$Skill)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$Skill[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$Skill;
	}
	
	/**
	 * @param string $uri
	 */
	public function getSkillName($uri) {
		if (!isset(self::$Skill[$uri]['name'])) {
			$rows = self::$bdd->getLabel($uri);
			
			if (isset($rows[0]['l'])) {
				self::$Skill[$uri]['name'] = ResourceProcessing::withoutURL($rows[0]['l']);
			} else {
				self::$Skill[$uri]['name'] = null;
			}
		
			$this->save();
		}
		
		return self::$Skill[$uri]['name'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getSkillParent($uri) {
		if (!isset(self::$Skill[$uri]['parent'])) {
			$rows = self::$bdd->getSkillParent($uri);
			
			if (isset($rows[0]['p'])) {
				self::$Skill[$uri]['parent'] = ResourceProcessing::withoutURL($rows[0]['p']);
			} else {
				self::$Skill[$uri]['parent'] = null;
			}
		
			$this->save();
		}
		
		return self::$Skill[$uri]['parent'];;
	}
	
	
	
	//Customer
	/**
	 * @return array
	 */
	public function getCustomerId() {
		$rows = self::$bdd->getListOfUri("Customer");
		
		if (sizeof($rows) != sizeof(self::$Customer)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$Customer[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$Customer;
	}
	
	/**
	 * @param string $uri
	 */
	public function getCustomerName($uri) {
		if (!isset(self::$Customer[$uri]['name'])) {
			$rows = self::$bdd->getName($uri);
			
			if (isset($rows[0]['n'])) {
				self::$Customer[$uri]['name'] = ResourceProcessing::withoutURL($rows[0]['n']);
			} else {
				self::$Customer[$uri]['name'] = null;
			}
		
			$this->save();
		}
		
		return self::$Customer[$uri]['name'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getCustomerFirstname($uri) {
		if (!isset(self::$Customer[$uri]['firstname'])) {
			$rows = self::$bdd->getFirstname($uri);
			
			if (isset($rows[0]['f'])) {
				self::$Customer[$uri]['firstname'] = ResourceProcessing::withoutURL($rows[0]['f']);
			} else {
				self::$Customer[$uri]['firstname'] = null;
			}
		
			$this->save();
		}
		
		return self::$Customer[$uri]['firstname'];;
	}
	
	
	
	//Resource
	/**
	 * @return array
	 */
	public function getResourceId() {
		$rows = self::$bdd->getListOfUri("Resource");
		
		if (sizeof($rows) != sizeof(self::$Resource)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$Resource[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$Resource;
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceName($uri) {
		if (!isset(self::$Resource[$uri]['name'])) {
			$rows = self::$bdd->getName($uri);
			
			if (isset($rows[0]['n'])) {
				self::$Resource[$uri]['name'] = ResourceProcessing::withoutURL($rows[0]['n']);
			} else {
				self::$Resource[$uri]['name'] = null;
			}
		
			$this->save();
		}
		
		return self::$Resource[$uri]['name'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceFirstname($uri) {
		if (!isset(self::$Resource[$uri]['firstname'])) {
			$rows = self::$bdd->getFirstname($uri);
			
			if (isset($rows[0]['f'])) {
				self::$Resource[$uri]['firstname'] = ResourceProcessing::withoutURL($rows[0]['f']);
			} else {
				self::$Resource[$uri]['firstname'] = null;
			}
		
			$this->save();
		}
		
		return self::$Resource[$uri]['firstname'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceBaseEfficiency($uri) {
		if (!isset(self::$Resource[$uri]['baseEfficiency'])) {
			$rows = self::$bdd->getResourceBaseEfficiency($uri);
			
			if (isset($rows[0]['bE'])) {
				self::$Resource[$uri]['baseEfficiency'] = ResourceProcessing::withoutURL($rows[0]['bE']);
			} else {
				self::$Resource[$uri]['baseEfficiency'] = null;
			}
		
			$this->save();
		}
		
		return self::$Resource[$uri]['baseEfficiency'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceSkillEfficiencies($uri) {
		if (!isset(self::$Resource[$uri]['skillEfficiency'])) {
			$rows = self::$bdd->getResourceSkillEfficiency($uri);
			self::$Resource[$uri]['skillEfficiency'] = array();
			
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($rows[$i]['sE'])) {
					self::$Resource[$uri]['skillEfficiency'][$i] = ResourceProcessing::withoutURL($rows[$i]['sE']);
				} else {
					self::$Resource[$uri]['skillEfficiency'][$i] = null;
				}
			}
			$this->save();
		}
		
		return self::$Resource[$uri]['skillEfficiency'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceHolidays($uri) {
		if (!isset(self::$Resource[$uri]['holidays'])) {
			$rows = self::$bdd->getResourceHolidays($uri);
			self::$Resource[$uri]['holidays'] = array();
			
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($rows[$i]['h'])) {
					self::$Resource[$uri]['holidays'][$i] = ResourceProcessing::withoutURL($rows[$i]['h']);
				} else {
					self::$Resource[$uri]['holidays'][$i] = null;
				}
			}
			$this->save();
		}
		
		return self::$Resource[$uri]['holidays'];
	}
	
	/**Get some resource with by a skill in common
	 * @param string $skillUri
	 */
	public function getResourceWithSkill($skillUri) {
		$rows = self::$bdd->getResourceWithSkill($skillUri);
		
		if (!isset(self::$Resource[$uri]['holidays'])) {
			
			self::$Resource[$uri]['holidays'] = array();
			
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($rows[$i]['r'])) {
					self::$Resource[$uri]['holidays'][$i] = ResourceProcessing::withoutURL($rows[$i]['r']);
				} else {
					self::$Resource[$uri]['holidays'][$i] = null;
				}
			}
			$this->save();
		}
		
		return self::$Resource[$uri]['holidays'];
		
	}
	
	/**
	 * @param string $resUri
	 */
	public function getResourceDevelopment($resUri) {
		
		$rows = self::$bdd->getResourceHolidays($uri);
		
		
		if (!isset(self::$Resource[$uri]['holidays'])) {
			
			self::$Resource[$uri]['holidays'] = array();
			
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($rows[$i]['h'])) {
					self::$Resource[$uri]['holidays'][$i] = ResourceProcessing::withoutURL($rows[$i]['h']);
				} else {
					self::$Resource[$uri]['holidays'][$i] = null;
				}
			}
			$this->save();
		}
		
		return self::$Resource[$uri]['holidays'];
		
	}
	
	
	
	//Development
	/**
	 * @return array
	 */
	public function getDevelopmentId() {
		$rows = self::$bdd->getListOfUri("Development");
		
		if (sizeof($rows) != sizeof(self::$Development)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$Development[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$Development;
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentName($uri) {
		if (!isset(self::$Development[$uri]['name'])) {
			$rows = self::$bdd->getLabel($uri);
			
			if (isset($rows[0]['l'])) {
				self::$Development[$uri]['name'] = ResourceProcessing::withoutURL($rows[0]['l']);
			} else {
				self::$Development[$uri]['name'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['name'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentParent($uri) {
		if (!isset(self::$Development[$uri]['parent'])) {
			$rows = self::$bdd->getDevelopmentParent($uri);
			
			if (isset($rows[0]['p'])) {
				self::$Development[$uri]['parent'] = ResourceProcessing::withoutURL($rows[0]['p']);
			} else {
				self::$Development[$uri]['parent'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['parent'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPrevious($uri) {
		if (!isset(self::$Development[$uri]['previous'])) {
			$rows = self::$bdd->getDevelopmentPrevious($uri);
			
			if (isset($rows[0]['p'])) {
				self::$Development[$uri]['previous'] = ResourceProcessing::withoutURL($rows[0]['p']);
			} else {
				self::$Development[$uri]['previous'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['previous'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentOptional($uri) {
		if (!isset(self::$Development[$uri]['optional'])) {
			$rows = self::$bdd->getDevelopmentOptional($uri);
			
			if (isset($rows[0]['o'])) {
				if (ResourceProcessing::withoutURL($rows[0]['o']) === "false") {
					self::$Development[$uri]['optional'] = false;
				} else if (ResourceProcessing::withoutURL($rows[0]['o']) === "true") {
					self::$Development[$uri]['optional'] = true;
				}
				
			} else {
				self::$Development[$uri]['optional'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['optional'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentEffort($uri) {
		if (!isset(self::$Development[$uri]['effort'])) {
			$rows = self::$bdd->getDevelopmentEffort($uri);
			
			if (isset($rows[0]['e'])) {
				self::$Development[$uri]['effort'] = intval(ResourceProcessing::withoutURL($rows[0]['e']));
			} else {
				self::$Development[$uri]['effort'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['effort'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentStatus($uri) {
		if (!isset(self::$Development[$uri]['status'])) {
			$rows = self::$bdd->getDevelopmentStatus($uri);
			
			if (isset($rows[0]['s'])) {
				self::$Development[$uri]['status'] = intval(ResourceProcessing::withoutURL($rows[0]['s']));
			} else {
				self::$Development[$uri]['status'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['status'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPlannedStart($uri) {
		if (!isset(self::$Development[$uri]['plannedStart'])) {
			$rows = self::$bdd->getDevelopmentPlannedStart($uri);
			
			if (isset($rows[0]['pS'])) {
				self::$Development[$uri]['plannedStart'] = ResourceProcessing::withoutURL($rows[0]['pS']);
			} else {
				self::$Development[$uri]['plannedStart'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['plannedStart'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPlannedEnd($uri) {
		if (!isset(self::$Development[$uri]['plannedEnd'])) {
			$rows = self::$bdd->getDevelopmentPlannedEnd($uri);
			
			if (isset($rows[0]['pE'])) {
				self::$Development[$uri]['plannedEnd'] = ResourceProcessing::withoutURL($rows[0]['pE']);
			} else {
				self::$Development[$uri]['plannedEnd'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['plannedEnd'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPriority($uri) {
		if (!isset(self::$Development[$uri]['priority'])) {
			$rows = self::$bdd->getPriority($uri);
			
			if (isset($rows[0]['p'])) {
				self::$Development[$uri]['priority'] = ResourceProcessing::withoutURL($rows[0]['p']);
			} else {
				self::$Development[$uri]['priority'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['priority'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentLateStart($uri) {
		if (!isset(self::$Development[$uri]['lateStart'])) {
			$rows = self::$bdd->getDevelopmentLateStart($uri);
			
			if (isset($rows[0]['lS'])) {
				self::$Development[$uri]['lateStart'] = ResourceProcessing::withoutURL($rows[0]['lS']);
			} else {
				self::$Development[$uri]['lateStart'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['lateStart'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentLateEnd($uri) {
		if (!isset(self::$Development[$uri]['lateEnd'])) {
			$rows = self::$bdd->getDevelopmentLateEnd($uri);
			
			if (isset($rows[0]['lE'])) {
				self::$Development[$uri]['lateEnd'] = ResourceProcessing::withoutURL($rows[0]['lE']);
			} else {
				self::$Development[$uri]['lateEnd'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['lateEnd'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentEarlyStart($uri) {
		if (!isset(self::$Development[$uri]['earlyStart'])) {
			$rows = self::$bdd->getDevelopmentEarlyStart($uri);
			
			if (isset($rows[0]['eS'])) {
				self::$Development[$uri]['earlyStart'] = ResourceProcessing::withoutURL($rows[0]['eS']);
			} else {
				self::$Development[$uri]['earlyStart'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['earlyStart'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentEarlyEnd($uri) {
		if (!isset(self::$Development[$uri]['earlyEnd'])) {
			$rows = self::$bdd->getDevelopmentEarlyEnd($uri);
			
			if (isset($rows[0]['eE'])) {
				self::$Development[$uri]['earlyEnd'] = ResourceProcessing::withoutURL($rows[0]['eE']);
			} else {
				self::$Development[$uri]['earlyEnd'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['earlyEnd'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentRealStart($uri) {
		if (!isset(self::$Development[$uri]['realStart'])) {
			$rows = self::$bdd->getDevelopmentRealStart($uri);
			
			if (isset($rows[0]['rS'])) {
				self::$Development[$uri]['realStart'] = ResourceProcessing::withoutURL($rows[0]['rS']);
			} else {
				self::$Development[$uri]['realStart'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['realStart'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentRealEnd($uri) {
		if (!isset(self::$Development[$uri]['realEnd'])) {
			$rows = self::$bdd->getDevelopmentRealEnd($uri);
			
			if (isset($rows[0]['rE'])) {
				self::$Development[$uri]['realEnd'] = ResourceProcessing::withoutURL($rows[0]['rE']);
			} else {
				self::$Development[$uri]['realEnd'] = null;
			}
		
			$this->save();
		}
		
		return self::$Development[$uri]['realEnd'];
	}
	
	/**
	 * Get some affected resources
	 * @param string $uri
	 */
	public function getDevelopmentResources($uri) {
		if (!isset(self::$Development[$uri]['resources'])) {
			$rows = self::$bdd->getDevelopmentResources($uri);
			self::$Development[$uri]['resources'] = array();
			
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($rows[$i]['r'])) {
					self::$Development[$uri]['resources'][$i] = ResourceProcessing::withoutURL($rows[$i]['r']);
				} else {
					self::$Development[$uri]['resources'][$i] = null;
				}
			}
			$this->save();
		}
		
		return self::$Development[$uri]['resources'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentSkillTags($uri) {
		if (!isset(self::$Development[$uri]['skillTags'])) {
			$rows = self::$bdd->getDevelopmentSkillTags($uri);
			self::$Development[$uri]['skillTags'] = array();
			
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($rows[$i]['sT'])) {
					self::$Development[$uri]['skillTags'][$i] = ResourceProcessing::withoutURL($rows[$i]['sT']);
				} else {
					self::$Development[$uri]['skillTags'][$i] = null;
				}
			}
			$this->save();
		}
		
		return self::$Development[$uri]['skillTags'];
	}
	
	
	
	//SkillEfficiency
	/**
	 * @return array
	 */
	public function getSkillEfficiencyId() {
		$rows = self::$bdd->getListOfUri("SkillEfficiency");
		
		if (sizeof($rows) != sizeof(self::$SkillEfficiency)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$SkillEfficiency[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$SkillEfficiency;
	}
	
	/**
	 * @param string $uri
	 */
	public function getSESkill($uri) {
		if (!isset(self::$SkillEfficiency[$uri]['skill'])) {
			$rows = self::$bdd->getSESkill($uri);
			
			if (isset($rows[0]['s'])) {
				self::$SkillEfficiency[$uri]['skill'] = ResourceProcessing::withoutURL($rows[0]['s']);
			} else {
				self::$SkillEfficiency[$uri]['skill'] = null;
			}
			
			$this->save();
		}
		
		return self::$SkillEfficiency[$uri]['skill'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getSEEfficiency($uri) {
		if (!isset(self::$SkillEfficiency[$uri]['efficiency'])) {
			$rows = self::$bdd->getSEEfficiency($uri);
			
			if (isset($rows[0]['e'])) {
				self::$SkillEfficiency[$uri]['efficiency'] = floatval(ResourceProcessing::withoutURL($rows[0]['e']));
			} else {
				self::$SkillEfficiency[$uri]['efficiency'] = null;
			}
			
			$this->save();
		}
		
		return self::$SkillEfficiency[$uri]['efficiency'];
	}
	
	
	
	//Holidays
	/**
	 * @return array
	 */
	public function getHolidaysId() {
		$rows = self::$bdd->getListOfUri("Holidays");
		
		if (sizeof($rows) != sizeof(self::$Holidays)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$Holidays[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$Holidays;
	}
	
	/**
	 * @param string $uri
	 */
	public function getHolidaysStart($uri) {
		if (!isset(self::$Holidays[$uri]['start'])) {
			$rows = self::$bdd->getHolidaysStart($uri);
			
			if (isset($rows[0]['s'])) {
				self::$Holidays[$uri]['start'] = ResourceProcessing::withoutURL($rows[0]['s']);
			} else {
				self::$Holidays[$uri]['start'] = null;
			}
			
			$this->save();
		}
		
		return self::$Holidays[$uri]['start'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getHolidaysEnd($uri) {
		if (!isset(self::$Holidays[$uri]['end'])) {
			$rows = self::$bdd->getHolidaysEnd($uri);
			
			if (isset($rows[0]['e'])) {
				self::$Holidays[$uri]['end'] = ResourceProcessing::withoutURL($rows[0]['e']);
			} else {
				self::$Holidays[$uri]['end'] = null;
			}
			
			$this->save();
		}
		
		return self::$Holidays[$uri]['end'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getHolidaysReason($uri) {
		if (!isset(self::$Holidays[$uri]['reason'])) {
			$rows = self::$bdd->getHolidaysReason($uri);
			
			if (isset($rows[0]['r'])) {
				self::$Holidays[$uri]['reason'] = ResourceProcessing::withoutURL($rows[0]['r']);
			} else {
				self::$Holidays[$uri]['reason'] = null;
			}
			
			$this->save();
		}
		
		return self::$Holidays[$uri]['reason'];
	}
	
	
	
	//CustomerMind
	/**
	 * @return array
	 */
	public function getCustomerMindId() {
		$rows = self::$bdd->getListOfUri("CustomerMind");
		
		if (sizeof($rows) != sizeof(self::$CustomerMind)) {
			for ($i = 0; $i < sizeof($rows); $i++) {
				self::$CustomerMind[ResourceProcessing::withoutURL($rows[$i]['s'])] = array(
						"id" => ResourceProcessing::withoutURL($rows[$i]['s'])
				);
			}
			
			$this->save();
		}
		return self::$CustomerMind;
	}
	
	/**
	 * @param string $uri
	 */
	public function getCMCustomer($uri) {
		if (!isset(self::$CustomerMind[$uri]['customer'])) {
			$rows = self::$bdd->getCMCustomer($uri);
				
			if (isset($rows[0]['c'])) {
				self::$CustomerMind[$uri]['customer'] = ResourceProcessing::withoutURL($rows[0]['c']);
			} else {
				self::$CustomerMind[$uri]['customer'] = null;
			}
				
			$this->save();
		}
	
		return self::$CustomerMind[$uri]['customer'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getCMMind($uri) {
		if (!isset(self::$CustomerMind[$uri]['mind'])) {
			$rows = self::$bdd->getCMMind($uri);
				
			if (isset($rows[0]['m'])) {
				self::$CustomerMind[$uri]['mind'] = ResourceProcessing::withoutURL($rows[0]['m']);
			} else {
				self::$CustomerMind[$uri]['mind'] = null;
			}
				
			$this->save();
		}
	
		return self::$CustomerMind[$uri]['mind'];
	}
}