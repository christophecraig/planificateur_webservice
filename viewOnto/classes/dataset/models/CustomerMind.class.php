<?php
require_once 'Customer.class.php';
require_once 'MindState.class.php';
/**
 * @author mbeacco
 *
 */
class CustomerMind {
	
	/**
	 * The CustomerMind id
	 * @var string
	 */
	private $id;
	
	/**
	 * An instance of Customer class
	 * @var Customer
	 */
	private $customer;
	
	/**
	 * An instance of Mind class
	 * @var MindState
	 */
	private $mind;
	
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
			$this->customer = $o['customer'];
			$this->mind = $o['mind'];
		}
	}
	
	/**
	 * Return a representation of a CustomerMind object
	 * @return array
	 */
	public function getCustomerMind() {
		return array(
				"id" => $this->id,
				"customer" => $this->customer,
				"mind" => $this->mind,
		);
	}
	
	/**
	 * 
	 */
	public function setCustomerMind() {
		$this->setCustomer();
		$this->setMind();
	}
	
	/**
	 * 
	 */
	public function setCustomer() {
		$this->customer = self::$factory->getCMCustomer($this->id);
	}
	
	/**
	 * 
	 */
	public function setMind() {
		$this->mind = self::$factory->getCMMind($this->id);
	}
}