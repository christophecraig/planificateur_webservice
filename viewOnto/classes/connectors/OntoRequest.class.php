<?php
require_once 'CopyOfSPARQLConnector.class.php';
/**
 * @author mbeacco
 *
 */
class OntoRequest extends SPARQLConnector {
	
	/**
	 * @var SPARQLConnector
	 */
	public $bdd;
	
	/**
	 * Le préfixe pour toutes les requêtes
	 * @var string
	 */
	private $PREFIX = '
			PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
			PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
			PREFIX ontoG: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
			PREFIX dataG: <http://localhost/~mbeacco/macro_planning/ontologie.xml/Dataset/>
			PREFIX pmbE: <http://www.pmbservices.fr/Entity/>
			PREFIX pmbP: <http://www.pmbservices.fr/Property/>
			PREFIX pmbData: <http://localhost/~mbeacco/macro_planning/ontologie.xml/Dataset/#>
			PREFIX xsd :<https://www.w3.org/TR/xmlschema11-2/#>
			';
	
	/**
	 * 
	 */
	public function __construct() {
		$this->bdd = parent::__construct();
	}
	
	/**
	 * Get all of the entities
	 * @return array
	 */
	public function getAllEntities() {
		$query = "
		SELECT ?s ?o WHERE {
		    GRAPH ontoG:
		    {
				?s rdf:type rdfs:Class .
				?s rdfs:comment ?o .
			}
		}
		";
	
		$rawResult = $this->bdd->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * Get all of the properties
	 * @return array
	 */
	public function getAllProperties() {
		$allProperties = "
		SELECT ?s ?o WHERE {
		    GRAPH ontoG:
		    {
				?s rdf:type rdf:Property .
				?s rdfs:comment ?o .
			}
		}
		";
	
		$rawResult = $this->bdd->query($this->PREFIX.$allProperties);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * Get all ranges of a property
	 * @param Property $property
	 */
	public function getRangeOfProperty($property) {
		$query = "
			SELECT ?r WHERE {
			    GRAPH ontoG:
			    {
					pmbP:".$property->getNom()." rdfs:range ?r .
				}
			}
		";
	
		$rawResult = $this->bdd->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * Get all domains of a property
	 * @param Property $property
	 */
	public function getDomainsOfProperty($property) {
		$query = "
			SELECT ?o WHERE {
			    GRAPH ontoG:
			    {
					pmbP:".$property->getNom()." rdfs:domain ?o .
				}
			}
		";
	
		$rawResult = $this->bdd->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * Because we have to handle every range singularly
	 * @param string $filter
	 */
	/*public function getPropertyRangeWithFilter($propertyName, $filter) {
	 $query = "
	 SELECT ?r WHERE {
	 GRAPH ontoG:
	 {
	 pmbP:".$propertyName." rdfs:range ?r .
	 FILTER (?r ".$filter.") .
	 }
	 }
	 ";
	 $rawResult = $this->bdd->query($this->PREFIX.$query);
	 return $rawResult['result']['rows'];
	 }*/
	
	/**
	 * Because we have to handle every datatype singularly
	 * @param string $filter
	 */
	/*public function getPropertyDatatypeWithFilter($propertyName, $filter) {
	 $query = "
	 SELECT ?d WHERE {
	 GRAPH ontoG:
	 {
	 pmbP:".$propertyName." rdfs:Datatype ?d .
	 FILTER (?d ".$filter.") .
	 }
	 }
	 ";
	 $rawResult = $this->bdd->query($this->PREFIX.$query);
	 return $rawResult['result']['rows'];
	 }*/
	
	/**
	 * Get all Datatypes of a property
	 * @param Property $property
	 */
	public function getPropertyDatatype($property) {
		$query = "
			SELECT ?d WHERE {
			    GRAPH ontoG:
			    {
					pmbP:".$property->getNom()." rdfs:Datatype ?d .
				}
			}
			";
		$rawResult = $this->bdd->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * Get all properties of an entity
	 * @param Entity $entity
	 */
	public function getPropertiesOfEntity($entity) {
		$query = "
			SELECT ?s WHERE {
			    GRAPH ontoG:
			    {
					?s rdfs:domain pmbE:".$entity->getNom()." .
				}
			}
		";
	
		$rawResult = $this->bdd->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
}