<?php
require_once 'SkillEfficiency.class.php';
require_once 'Holidays.class.php';
require_once './Factory.class.php';
/**
 * @author mbeacco
 * @uses Instance des ressource du planning
 */
class Resource {
	
	/**
	 * @var string
	 */
	private $id;
	
	/**
	 * Nom de la Ressource
	 * @var String
	 */
	private $name;
	
	/**
	 * Prénom de la Ressource
	 * @var String
	 */
	private $firstName;
	
	/**
	 * Efficacité moyenne de la Ressource
	 * @var float
	 */
	private $baseEfficiency;
	
	/**
	 * Toutes les vacances prises et prévues de la ressources.
	 * @var array
	 */
	private $holidays;
	
	/**
	 * Toutes les efficacités par compétence
	 * @var array
	 */
	private $skillEfficiency;
	
	private static $factory;
	
	/**
	 * Instanciation d'une ressource
	 * @param String $id
	 * @param DataRequest $bdd
	 */
	public function __construct($id, $bdd, $o = NULL) {
		$this->id = $id;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
		
		if (isset($o)) {
			$this->name = $o['name'];
			$this->firstName = $o['firstName'];
		}
	}
	
	/**
	 * Set all attributes of a Resource
	 */
	public function setResource() {
		$this->setName();
		$this->setFirstname();
		$this->setSkillEfficiencies();
		$this->setResourceHolidays();
		$this->setBaseEfficiency();
		
	}
	
	/**
	 * Give a array representation of a Resource
	 * @return array
	 */
	public function getResource() {
		return array(
				"id" => $this->id,
				"name" => $this->name,
				"firstName" => $this->firstName,
				"baseEfficiency" => $this->baseEfficiency,
				"holidays" => $this->holidays,
				"skillEfficiency" => $this->skillEfficiency,
		);
	}
	
	/**
	 * Set the Resource identity
	 */
	public function setIdentity() {
		$this->setName();
		$this->setFirstname();
	}
	
	/**
	 * Give a array representation of the Resource' identity
	 * @return array
	 */
	public function getIdentity() {
		return array(
				"id" => $this->id,
				"name" => $this->name,
				"firstName" => $this->firstName,
		);
	}
	
	/**
	 * Set holidays period of a Resource
	 */
	public function setResourceHolidays() {
		$this->holidays = self::$factory->getResourceHolidays($this->id);
	}
	
	/**
	 * Give all holidays period
	 */
	public function getResourceHolidays() {
		return $this->holidays;
	}
	
	/**
	 * Get id
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set id
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Retourne le nom de la ressource
	 * @return string
	 */
	public function setName() {
		$this->name = self::$factory->getResourceName($this->id);
	}
	
	/**
	 * Retourne le prénom de la ressource
	 * @return string
	 */
	public function setFirstname() {
		$this->firstName = self::$factory->getResourceFirstname($this->id);
	}
	
	/**
	 * Set base efficiency
	 */
	public function setBaseEfficiency() {
		$this->baseEfficiency = floatval(self::$factory->getResourceBaseEfficiency($this->id));
	}
	
	/**
	 * Get base efficiency
	 * @return number
	 */
	public function getBaseEfficiency() {
		return $this->baseEfficiency;
	}
	
	/**
	 * Set all skill efficiencies
	 */
	public function setSkillEfficiencies() {
		$this->skillEfficiency = self::$factory->getResourceSkillEfficiencies($this->id);
	}
	
	/**
	 * Get all skill efficiencies
	 * @return array
	 */
	public function getSkillEfficiencyE() {
		$response = array();
		for ($i = 0; $i < sizeof($this->skillEfficiency); $i++) {
			$response[$i] = self::$factory->getSEEfficiency($this->skillEfficiency[$i]);
		}
		return $response;
	}
	
	/**
	 * May be this resource have a control in this skill ?
	 * @param string $skill
	 * @return boolean
	 */
	public function resourceHaveSkill($skill) {
		if (!isset($this->skillEfficiency)) {
			$this->setSkillEfficiencies();
		}
		
		for ($i = 0; $i < sizeof($this->skillEfficiency); $i++) {
			if (self::$factory->getSESkill($this->skillEfficiency[$i]) == $skill) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Ajoute une efficacité de compétence à la ressource
	 * @param SkillEfficiency $effComp
	 */
	public function addEffCompetence($effComp) {
		$this->skillEfficiency[$effComp->getSkillName()] = $effComp;
		$this->setEffMoyenne();
	}
}