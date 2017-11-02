<?php
require_once 'CustomerMind.class.php';
require_once 'Priority.class.php';
require_once 'MindState.class.php';
require_once './Factory.class.php';
/**
 * @author mbeacco
 * @filesource Project.class.php
 *
 */
class Project {
	
	/**
	 * @var string
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var CustomerMind
	 * @var Customer
	 */
	private $customer;
	
	/**
	 * @var Priority
	 */
	private $priority;
	
	/**
	 * @var MindState
	 */
	private $developersMind;
	
	/**
	 * @var array
	 */
	private $devs;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * @param string $id
	 * @param DataRequest $bdd
	 */
	public function __construct($id, $bdd, $o = NULL) {
		$this->id = $id;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
		
		if (isset($o)) {
			$this->name = $o['name'];
			$this->priority = $o['priority'];
			$this->customer = $o['customer'];
			$this->developersMind = $o['developersMind'];
		}
		
	}
	
	/**
	 * 
	 */
	public function setName() {
		$this->name = self::$factory->getProjectName($this->id);
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * 
	 */
	public function setPriority() {
		$this->priority = self::$factory->getProjectPriority($this->id);
	}
	
	/**
	 * 
	 */
	public function setCustomer() {
		$this->customer = self::$factory->getProjectCustomer($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopersMind() {
		$this->developersMind = self::$factory->getProjectDevelopersMind($this->id);
	}
	
	/**
	 * 
	 */
	public function setDevelopments() {
		$this->devs = self::$factory->getProjectDevelopments($this->id);
	}
	
	/**
	 * 
	 */
	public function setDetails() {
		$this->setName();
		$this->setPriority();
		$this->setCustomer();
		$this->setDevelopersMind();
		$this->setDevelopments();
	}
	
	/**
	 * @return array
	 */
	public function getDetails() {
		$response = array(
				"id" => $this->id,
				"name" => $this->name,
				"priority" => $this->priority,
				"customer" => $this->customer,
				"developersMind" => $this->developersMind,
		);
		
		if (isset($this->devs)) {
			for ($i = 0; $i < sizeof($this->devs); $i++) {
				$response["developments"][$i] = $this->devs[$i];
			}
		}
		

		return $response;
	}
	
	/**
	 * @param string $d
	 */
	public function addDevelopment($d) {
		$index = sizeof($this->devs);
		$this->devs[$index] = $d;
	}
	
	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
}