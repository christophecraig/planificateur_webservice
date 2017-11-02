<?php
/**
 * @author mbeacco
 * Instance des compétance pour les développements
 */
class Skill {
	
	/**
	 * @var string
	 */
	private $id;
	
	/**
	 * Nom de la compétence
	 * @var String
	 */
	private $name;
	
	/**
	 * Compétence parente si elle existe, vaut NULL sinon
	 * @var Skill
	 */
	private $parentSkill;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * Instanciation d'une compétence
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
			$this->parentSkill = $o['parent'];
		}
	}
	
	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * 
	 */
	public function setName() {
		$this->name = self::$factory->getSkillName($this->id);
	}
	
	/**
	 * Modifie le nom d'une compétence
	 * @return string
	 */
	public function getNom() {
		return $this->name;
	}
	
	/**
	 * 
	 */
	public function setParent() {
		$this->compParente = self::$factory->getSkillParent($this->id);
	}
	
	/**
	 * Modifie la compétence parente
	 * @return string
	 */
	public function getParent() {
		return $this->parentSkill;
	}
	
	/**
	 * 
	 */
	public function setSkill() {
		$this->getName();
		$this->getParent();
	}
	
	/**
	 * @return array
	 */
	public function getSkill() {
		return array(
				"id" => $this->id,
				"name" => $this->name,
				"parent" => $this->parentSkill,
		);
	}
}