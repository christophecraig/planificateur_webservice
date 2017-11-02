<?php

/**
 * @author mbeacco
 *
 */
class Property {
	
	/**
	 * Le nom de la propriété
	 * @var string
	 */
	public $nom;
	
	/**
	 * La description de la propriété
	 * @var string
	 */
	public $description;
	
	/**
	 * Ce que la propriété peut prendre comme valeur de triplet
	 * @var array
	 */
	public $range;
	
	/**
	 * La liste des entités auxquelles la propriété est affectée
	 * @var array
	 */
	public $domain;
	
	/**
	 * On construit la propriété avec son nom, sa description et son range
	 * @param string $nom Nom de la propriété
	 * @param string $description Description de la propriété
	 * @param Entity $range Valeur que peut prendre la propriété
	 */
	public function __construct($nom, $description) {
		$this->nom = $nom;
		$this->description = $description;
		$this->domain = array();
	}
	
	/**
	 * On affiche la propriété
	 * @return string
	 */
	public function __toString() {
		$msg = "Nom : ".$this->nom.". Description : ".$this->description.". Range : ".$this->range.". Domaines : ";
		for ($i = 0; $i < sizeof($this->domain); $i++) {
			$msg .= $this->domain[$i]->getNom().", ";
		}
		
		return $msg.".";
	}
	
	/**
	 * On retourne le nom de la propriété
	 * @return string
	 */
	public function getNom() {
		return $this->nom;
	}
	
	/**
	 * On modifie le nom de la propriété
	 * @param string $nom Nom de la propriété
	 */
	public function setNom($nom) {
		$this->nom = $nom;
	}
	
	/**
	 * On retourne la description de la propriété
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * On modifie la description de la propriété
	 * @param string $description Description de la propriété
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * On retourne le range de la propriété
	 * @return array
	 */
	public function getRange() {
		return $this->range;
	}
	
	/**
	 * On modifie le range de la propriété
	 * @param Entity $range Valeur que peut prendre la propriété
	 */
	public function addRange($range) {
		$index = sizeof($this->range);
		$this->range[$index] = $range;
	}
	
	/**
	 * On retourne la liste des domaines de la propriété
	 * @return array 
	 */
	public function getDomain() {
		return $this->domain;
	}
	
	/**
	 * On ajoute un domaine à la propriété
	 * @param Entity $entity Domaine de la propriété
	 */
	public function addDomain($entity) {
		$index = sizeof($this->domain);
		$this->domain[$index] = $entity;
	}
	
}