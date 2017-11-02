<?php
require_once 'Resource.class.php';
require_once 'Skill.class.php';
require_once './controllers/ResourceProcessing.class.php';
/**
 * @author mbeacco
 * It' a development instance for the schedule
 */
class Development {
	
	/**
	 * Development's ID
	 * @var string
	 */
	private $id;
	
	/**
	 * Development's name
	 * @var string
	 */
	private $name;
	
	/**
	 * Development's duration
	 * @var int
	 */
	private $duration;
	
	/**
	 * Earliest start for a development
	 * @var string
	 */
	private $earlyStart;
	
	/**
	 * Latest start for a development
	 * @var string
	 */
	private $lateStart;
	
	/**
	 * Planned start for a development
	 * @var string
	 */
	private $plannedStart;
	
	/**
	 * Real start for a development
	 * @var string
	 */
	private $realStart;
	
	/**
	 * Earliest end for a development
	 * @var string
	 */
	private $earlyEnd;
	
	/**
	 * Latest end for a development
	 * @var string
	 */
	private $lateEnd;
	
	/**
	 * Real end for a development
	 * @var string
	 */
	private $realEnd;
	
	/**
	 * Planned end for a development
	 * @var string
	 */
	private $plannedEnd;
	
	/**
	 * True if it's an optional development, false if not
	 * @var boolean
	 */
	private $optional;
	
	/**
	 * Advancement status of a development
	 * @var int
	 */
	private $status;
	
	/**
	 * Defined if we have a previous development, null if not
	 * @var string
	 */
	private $previousDevelopment;
	
	/**
	 * Defined if we have a parent development, null if not
	 * @var string
	 */
	private $parentDevelopment;
	
	/**
	 * Development's effort
	 * @var int
	 */
	private $effort;
	
	/**
	 * It's a list of necessary skills for a development
	 * @var array
	 */
	private $skillTags;
	
	/**
	 * Development's priority
	 * @var string
	 */
	private $priority;
	
	/**
	 * It's a list of affected resource to a development
	 * @var array
	 */
	private $resources;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * Construct a development
	 * @param string $id - Development's ID
	 * @param DataRequest $bdd
	 */
	public function __construct($id, $bdd, $o = NULL) {
		$this->id = $id;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
		
		if (isset($o)) {
			$this->name = $o['name'];
			$this->duration = $o['duration'];
			$this->earlyStart = $o['earlyStart'];
			$this->lateStart = $o['lateStart'];
			$this->realStart = $o['realStart'];
			$this->plannedStart = $o['plannedStart'];
			$this->earlyEnd = $o['earlyEnd'];
			$this->lateEnd = $o['lateEnd'];
			$this->realEnd = $o['realEnd'];
			$this->plannedEnd = $o['plannedEnd'];
			$this->priority = $o['priority'];
			$this->status = $o['status'];
			$this->optional = $o['optional'];
			$this->effort = $o['effort'];
		}
	}
	
	/**
	 * 
	 */
	public function setDetails() {
		$this->setName();
		$this->setParentDevelopment();
		$this->setPreviousDevelopment();
		$this->setDevelopmentOptional();
		$this->setDevelopmentEffort();
		$this->setDevelopmentStatus();
		$this->setDevelopmentPlannedStart();
		$this->setDevelopmentPlannedEnd();
		$this->setDevelopmentPriority();
		$this->setDevelopmentLateStart();
		$this->setDevelopmentLateEnd();
		$this->setDevelopmentEarlyStart();
		$this->setDevelopmentEarlyEnd();
		$this->setDevelopmentRealStart();
		$this->setDevelopmentRealEnd();
		$this->setDevelopmentResources();
		$this->setDevelopmentSkillTag();
		$this->setDuration();
	}
	
	/**
	 * Return a array representation of a development
	 * @return array 
	 */
	public function getDetails() {
		return array(
				"id" => $this->id,
				"name" => $this->name,
				"earlyStart" => $this->earlyStart,
				"lateStart" => $this->lateStart,
				"realStart" => $this->realStart,
				"plannedStart" => $this->plannedStart,
				"earlyEnd" => $this->earlyEnd,
				"lateEnd" => $this->lateEnd,
				"realEnd" => $this->realEnd,
				"plannedEnd" => $this->plannedEnd,
				"status" => $this->status,
				"optional" => $this->optional,
				"effort" => $this->effort,
				"priority" => $this->priority,
				"previousDevelopment" => $this->previousDevelopment,
				"parentDevelopment" => $this->parentDevelopment,
				"resources" => $this->resources,
				"skillTags" => $this->skillTags,
		);
	}
	
	/**
	 * Set the previous development
	 * @param Object $devPrec
	 */
	public function setPreviousDevelopment() {
		$this->previousDevelopment = self::$factory->getDevelopmentPrevious($this->id);
	}
	
	/**
	 * Set the parent development
	 * @param Object $devParent
	 */
	public function setParentDevelopment() {
		$this->parentDevelopment = self::$factory->getDevelopmentParent($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentOptional() {
		$this->optional = self::$factory->getDevelopmentOptional($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentEffort() {
		$this->effort = self::$factory->getDevelopmentEffort($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentStatus() {
		$this->status = self::$factory->getDevelopmentStatus($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentPlannedStart() {
		$this->plannedStart = self::$factory->getDevelopmentPlannedStart($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentPlannedEnd() {
		$this->plannedEnd = self::$factory->getDevelopmentPlannedEnd($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentPriority() {
		$this->priority = self::$factory->getDevelopmentPriority($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentLateStart() {
		$this->lateStart = self::$factory->getDevelopmentLateStart($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentLateEnd() {
		$this->lateEnd = self::$factory->getDevelopmentLateEnd($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentEarlyStart() {
		$this->earlyStart = self::$factory->getDevelopmentEarlyStart($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentEarlyEnd() {
		$this->earlyEnd = self::$factory->getDevelopmentEarlyEnd($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentRealStart() {
		$this->realStart = self::$factory->getDevelopmentRealStart($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopmentRealEnd() {
		$this->realEnd = self::$factory->getDevelopmentRealEnd($this->id);
	}
	
	/**
	 * Add a resource to a development
	 * @param Resource $r
	 */
	public function addRessource($r) {
		$index = sizeof($this->resources);
		$this->resources[$index] = $r;
	}
	
	/**
	 * Add a skill to the skill list of a development
	 * @param Skill $c
	 */
	public function addCompetence($c) {
		$index = sizeof($this->skillTags);
		$this->skillTags[$index] = $c;
	}
	
	/**
	 * Return the development's name
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * 
	 */
	public function setName() {
		$this->name = self::$factory->getDevelopmentName($this->id);
	}
	
	/**
	 * Return the development's ID
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Get effected resources
	 */
	public function setDevelopmentResources() {
		$this->resources = self::$factory->getDevelopmentResources($this->id);
	}
	
	/**
	 * Get skill tags
	 */
	public function setDevelopmentSkillTag() {
		$this->skillTags = self::$factory->getDevelopmentSkillTags($this->id);
	}
	
	/**
	 * Set the duration of a development
	 */
	public function setDuration() {
		$this->duration = $this->effort;
	}
	
	/**
	 * @param int $d
	 */
	public function modifyDuration($d) {
		$this->duration = $d;
	}
}