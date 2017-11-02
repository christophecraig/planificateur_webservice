<?php
require_once './Factory.class.php';
/**
 * @author mbeacco
 *
 */
class WeightedList {
	
	/**
	 * @var string
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var float
	 */
	private $weight;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * @param string $id
	 * @param string $n
	 * @param float $p
	 */
	protected function __construct($id, $bdd) {
		$this->id = $id;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
	}
	
	/**
	 * @return string
	 */
	protected function getId() {
		return $this->id;
	}
	
	/**
	 * @param string $id
	 */
	protected function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * 
	 */
	protected function setName() {
		$this->name = self::$factory->getWLName($this->id);
	}
	
	/**
	 * 
	 */
	protected function setWeight() {
		$this->weight = floatval(self::$factory->getWLWeight($this->id));
	}
	
	/**
	 * 
	 */
	protected function setWeightedList() {
		$this->setName();
		$this->setWeight();
	}
	
	/**
	 * @return array
	 */
	protected function getWeightedList() {
		return array(
			"id" => $this->id,
			"name" => $this->name,
			"weight" => $this->weight,
		);
	}
}