<?php
/**
 * @author mbeacco
 * Just a customer, without his mind state
 */
class Customer {
	
	/**
	 * Customer id
	 * @var string
	 */
	private $id;
	
	/**
	 * Customer name
	 * @var string
	 */
	private $name;
	
	/**
	 * Customer firstname
	 * @var string
	 */
	private $firstName;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * Construct an object
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
			$this->firstName = $o['firstName'];
		}
	}
	
	/**
	 * Get the customer id
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set the customer id
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Get the customer name
	 * @return string
	 */
	public function setName() {
		$this->name = self::$factory->getCustomerName($this->id);
	}
	
	/**
	 * Get the customer firstname
	 * @return string
	 */
	public function setFirstname() {
		$this->firstName = self::$factory->getCustomerFirstname($this->id);
	}
	
	/**
	 * Return a representation of a Customer object
	 * @return array
	 */
	public function getCustomer() {
		return array(
				"id" => $this->id,
				"name" => $this->name,
				"firstName" => $this->firstName,
		);
	}
	
	/**
	 * 
	 */
	public function setCustomer() {
		$this->setName();
		$this->setFirstname();
	}
}