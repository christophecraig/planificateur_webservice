<?php
require_once 'WeightedList.class.php';
/**
 * @author mbeacco
 *
 */
class MindState extends WeightedList {
	
	/**
	 * @param string $id
	 * @param DataRequest $bdd
	 */
	public function __construct($id, $bdd) {
		parent::__construct($id, $bdd);
	}
	
	/**
	 * @return string
	 */
	public function getId() {
		return parent::getId();
	}
	
	/**
	 * @param string $id
	 */
	public function setId($id) {
		parent::setId($id);
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return parent::getName();
	}
	
	/**
	 * 
	 */
	public function setName() {
		parent::setName();
	}
	
	/**
	 * @return float
	 */
	public function getWeight() {
		return parent::getWeight();
	}
	
	/**
	 * 
	 */
	public function setWeight() {
		parent::setWeight();
	}
	
	/**
	 * 
	 */
	public function setMindState() {
		parent::setWeightedList();
	}
	
	/**
	 * @return array
	 */
	public function getMindState() {
		return parent::getWeightedList();
	}
}