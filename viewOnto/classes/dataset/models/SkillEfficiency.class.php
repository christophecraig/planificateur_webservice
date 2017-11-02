<?php
require_once './Factory.class.php';
/**
 * @author mbeacco
 * @uses Instance d'une compéteence relié à l'efficacité d'une ressource sur cette compétence
 */
class SkillEfficiency {
	
	/**
	 * @var string
	 */
	private $id;
	
	/**
	 * La compétence en question
	 * @var Skill
	 */
	private $skill;
	
	/**
	 * L'efficacité de la ressource sur cette compétence
	 * @var float
	 */
	private $efficiency;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * Instanciation d'une efficacité de compétence
	 * @param string $id
	 * @param DataRequest $bdd
	 */
	public function __construct($id, $bdd, $o = NULL) {
		$this->id = $id;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
		
		if (isset($o)) {
			$this->skill = $o['skill'];
			$this->efficiency = $o['efficiency'];
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
	public function setSkill() {
		$this->skill = self::$factory->getSESkill($this->id);
	}
	
	/**
	 * 
	 */
	public function setEfficiency() {
		$this->efficiency = self::$factory->getSEEfficiency($this->id);
	}
	
	/**
	 * @return number
	 */
	public function getEfficiency() {
		return $this->efficiency;
	}
	
	/**
	 * 
	 */
	public function setSkillEfficiency() {
		$this->setSkill();
		$this->setEfficiency();
	}
	
	/**
	 * @return array
	 */
	public function getSkillEfficiency() {
		return array(
				"id" => $this->id,
				"skill" => $this->skill,
				"efficiency" => $this->efficiency,
		);
	}
}