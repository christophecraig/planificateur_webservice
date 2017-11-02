<?php
/**
 * @author mbeacco
 *
 */
class Entity {
	
	/**
	 * Le nom de l'entité
	 * @var string
	 */
	public $nom;
	
	/**
	 * La description d l'entité (rdfs:comment)
	 * @var string 
	 */
	public $description;
	
	/**
	 * La liste des propriétés associées à l'entité
	 * @var array
	 */
	public $propertyList;
	
	/**
	 * On construit l'entité uniquement avec son nom et sa description, on ajoute les propriétés plus tard
	 * @param string $nom Nom de l'entité
	 * @param string $description Description de l'entité
	 */
	public function __construct($nom, $description) {
		$this->nom = $nom;
		$this->description = $description;
		$this->propertyList = array();
	}
	
	/**
	 * On retourne une présentation de l'entité
	 * @return string
	 */
	public function __toString() {
		$msg = "Entity : ".$this->nom.". Description : ".$this->description.". Propriétés : ";
		for ($i = 0; $i < sizeof($this->propertyList); $i++) {
			$msg .= $this->propertyList[$i]->getNom().", ";
		}
		
		return $msg.".";
	}
	
	/**
	 * On retourne le nom de l'entité
	 * @return string
	 */
	public function getNom() {
		return $this->nom;
	}
	
	/**
	 * On modifie le nom de l'entité
	 * @param string $nom Nom de l'entité
	 */
	public function setNom($nom) {
		$this->nom;
	}
	
	/**
	 * On retourne la description de l'entité
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * On modifie la description
	 * @param string $description Description de l'entité
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * On retourne le tableau des propriétés
	 * @return array
	 */
	public function getProperty() {
		return $this->propertyList;
	}
	
	/**
	 * On ajoute une propriété à l'entité
	 * @param Property $property Une propriété de l'entité
	 */
	public function addProperty($property) {
		$index = sizeof($this->propertyList);
		$this->propertyList[$index] = $property;
	}
}