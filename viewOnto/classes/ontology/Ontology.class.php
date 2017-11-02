<?php
require 'Entity.class.php';
require 'Property.class.php';

/**
 * @author mbeacco
 *
 */
class Ontology {
	
	/**
	 * Tableau de toutes les entités
	 * @var array
	 */
	public $Entity;
	
	/**
	 * Tableau de toutes les prorpiétés
	 * @var array
	 */
	public $Property;
	
	/**
	 * Construction de l'ontologie selon ce qui est demandé
	 * @param SPARQLConnector $connector
	 * @param array $demand
	 */
	public function __construct($connector) {
		$this->getEntities($connector);
		$this->getProperties($connector);
		$this->addDomainsAndRangesAndPropertiesInList($connector);
	}
	
	
	/**
	 * On supprime les URL
	 * @param string $string
	 * @return string
	 */
	protected function withoutURL($string) {
		if (preg_match("/Entity/", $string)) {
			$temp = explode('http://www.pmbservices.fr/Entity/', $string);
			return $temp[1];
		} else if (preg_match("/Property/", $string)) {
			$temp = explode('http://www.pmbservices.fr/Property/', $string);
			return $temp[1];
		} else if (preg_match("/rdf-schema#/", $string)) {
			$temp = explode('http://www.w3.org/2000/01/rdf-schema#', $string);
			return "rdfs:".$temp[1];
		} else if (preg_match("/xmlschema11-2/", $string)) {
			$temp = explode('https://www.w3.org/TR/xmlschema11-2/#', $string);
			return "xsd:".$temp[1];
		}
	}
	
	/**
	 * On rentre toutes les entités dans le tableau
	 * @param SPARQLConnector $connector
	 */
	protected function getEntities($connector) {
		$rows = $connector->getAllEntities();
		$amountOfEntities = sizeof($rows);
		
		for ($i = 0; $i < $amountOfEntities; $i++) {	
			$nom = $this->withoutURL($rows[$i]['s']);
			$entity = new Entity($nom, $rows[$i]['o']);
			$this->Entity[$nom] = $entity;
		}
	}
	
	/**
	 * On rentre toutes les propriétés dans le tableau
	 * @param SPARQLConnector $connector
	 */
	protected function getProperties($connector) {
		$rows = $connector->getAllProperties();
		$amountOfProperties = sizeof($rows);
	
		for ($i = 0; $i < $amountOfProperties; $i++) {
				
			$nom = $this->withoutURL($rows[$i]['s']);
			$property = new Property($nom, $rows[$i]['o']);
			$this->Property[$nom] = $property;
		}
	}
	
	/**
	 * On ajoute les domaines dans les propriétés et les propriétés dans les propertyList
	 * @param SPARQLConnector $connector
	 */
	protected function addDomainsAndRangesAndPropertiesInList($connector) {
		/*
		 * On rentre les domaines
		 */
		
		foreach ($this->Property as $property) {
			$rows = $connector->getDomainsOfProperty($property);
			for ($i = 0; $i < sizeof($rows); $i++) {
				$property->addDomain($this->Entity[$this->withoutURL($rows[$i]['o'])]);
			}
		}
		
		/*
		 * On rentre les range correctement
		 */
		foreach ($this->Property as $property) {
			$rows = $connector->getRangeOfProperty($property);
			for ($i = 0; $i < sizeof($rows); $i++) {
				$property->addRange($this->withoutURL($rows[$i]['r']));
			}
			
			$rows = $connector->getPropertyDatatype($property);
			for ($i = 0; $i < sizeof($rows); $i++) {
				$property->addRange($this->withoutURL($rows[$i]['d']));
			}
			
		}
		
		/*
		 * On ajoute les propriétés dans les entités
		 */
		foreach ($this->Entity as $entity) {
			$rows = $connector->getPropertiesOfEntity($entity);
			for ($i = 0; $i < sizeof($rows); $i++) {
				$entity->addProperty($this->Property[$this->withoutURL($rows[$i]['s'])]);
			}
		}
	}
	
}