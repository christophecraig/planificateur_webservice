<?php
require_once './../connectors/SPARQLConnector.class.php';
/**
 * @author mbeacco
 *
 */
class DataRequest extends SPARQLConnector {
	
	/**
	 * The store :)
	 * @var SPARQLConnector
	 */
	public $store;
	
	/**
	 * The query prefix
	 * @var string
	 */
	private $PREFIX = '
			PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
			PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
			PREFIX ontoG: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
			PREFIX dataG: <http://www.pmbservices.fr/Dataset/>
			PREFIX pmbE: <http://www.pmbservices.fr/Entity/>
			PREFIX pmbP: <http://www.pmbservices.fr/Property/>
			PREFIX pmbData: <http://www.pmbservices.fr/Dataset/#>
			PREFIX xsd :<https://www.w3.org/TR/xmlschema11-2/#>
			';
	
	/**
	 * Build an instance of SPARQL connector
	 */
	public function __construct() {
		$this->store = parent::__construct();
	}
	
	/*
	 * Insertion
	 */
	
	
	
	/**
	 * Add a project
	 * @param Project $projectContent
	 */
	public function insertProject($projectContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$projectContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Project> .
				<http://www.pmbservices.fr/Dataset/#".$projectContent['id']."> <http://www.w3.org/2000/01/rdf-schema#label> \"".$projectContent['name']."\" .
				<http://www.pmbservices.fr/Dataset/#".$projectContent['id']."> <http://www.pmbservices.fr/Property/priority> <http://www.pmbservices.fr/Dataset/#".$projectContent['priority']."> .
				<http://www.pmbservices.fr/Dataset/#".$projectContent['id']."> <http://www.pmbservices.fr/Property/customer> <http://www.pmbservices.fr/Dataset/#".$projectContent['customer']."> .
			";
		
		if (isset($projectContent['developersMind'])) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$projectContent['id']."> <http://www.pmbservices.fr/Property/developersMind> <http://www.pmbservices.fr/Dataset/#".$projectContent['developersMind'].">  .";
		}
		
		$insert .= "}";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a client
	 * @param array $clientContent
	 */
	public function insertCustomer($customerContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$customerContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Customer> .
				<http://www.pmbservices.fr/Dataset/#".$customerContent['id']."> <http://www.pmbservices.fr/Property/name> \"".$customerContent['name']."\" .
				<http://www.pmbservices.fr/Dataset/#".$customerContent['id']."> <http://www.pmbservices.fr/Property/firstname> \"".$customerContent['firstName']."\" .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a resource
	 * @param array $resourceContent
	 */
	public function insertResource($resourceContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$resourceContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Resource> .
				<http://www.pmbservices.fr/Dataset/#".$resourceContent['id']."> <http://www.pmbservices.fr/Property/name> \"".$resourceContent['name']."\" .
				<http://www.pmbservices.fr/Dataset/#".$resourceContent['id']."> <http://www.pmbservices.fr/Property/firstname> \"".$resourceContent['firstName']."\" .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a skill
	 * @param array $skillContent
	 */
	public function insertSkill($skillContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$skillContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Skill> .
				<http://www.pmbservices.fr/Dataset/#".$skillContent['id']."> <http://www.w3.org/2000/01/rdf-schema#label> \"".$skillContent['name']."\" .
			";
		
		if ($skillContent['parent'] != null) {
			$insert .= "	<http://www.pmbservices.fr/Dataset/#".$skillContent['id']."> <http://www.pmbservices.fr/Property/parentskill> <http://www.pmbservices.fr/Dataset/#".$skillContent['parent']['id']."> .";
		}
		
		$insert .= "
			}";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add an holidays period to a resource
	 * @param array $holidaysContent
	 */
	public function insertHolidays($holidaysContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$holidaysContent['holidays']['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Holidays> .
				<http://www.pmbservices.fr/Dataset/#".$holidaysContent['holidays']['id']."> <http://www.pmbservices.fr/Property/holidaysStart> \"".$holidaysContent['holidays']['beginning']."\" .
				<http://www.pmbservices.fr/Dataset/#".$holidaysContent['holidays']['id']."> <http://www.pmbservices.fr/Property/holidaysEnd> \"".$holidaysContent['holidays']['ending']."\" .
				<http://www.pmbservices.fr/Dataset/#".$holidaysContent['holidays']['id']."> <http://www.pmbservices.fr/Property/holidaysReason> \"".$holidaysContent['holidays']['reason']."\" .
						
				<http://www.pmbservices.fr/Dataset/#".$holidaysContent['resourceId']."> <http://www.pmbservices.fr/Property/resourceUnavailability> <http://www.pmbservices.fr/Dataset/#".$holidaysContent['holidays']['id']."> .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a skill efficiency to a resource
	 * @param array $skillEfficiencyContent
	 */
	public function insertSkillEfficiency($skillEfficiencyContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$skillEfficiencyContent['skillEfficiency']['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/SkillEfficiency> .
				<http://www.pmbservices.fr/Dataset/#".$skillEfficiencyContent['skillEfficiency']['id']."> <http://www.pmbservices.fr/Property/skill> <http://www.pmbservices.fr/Dataset/#".$skillEfficiencyContent['skillEfficiency']['skill']."> .
				<http://www.pmbservices.fr/Dataset/#".$skillEfficiencyContent['skillEfficiency']['id']."> <http://www.pmbservices.fr/Property/skillEfficiency> \"".$skillEfficiencyContent['skillEfficiency']['efficiency']."\" .
				
				<http://www.pmbservices.fr/Dataset/#".$skillEfficiencyContent['resourceId']."> <http://www.pmbservices.fr/Property/skillEfficiency> <http://www.pmbservices.fr/Dataset/#".$skillEfficiencyContent['skillEfficiency']['id']."> .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a development and link it to a project
	 * @param array $developmentContent
	 */
	public function insertDevelopment($developmentContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Development> .
				<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.w3.org/2000/01/rdf-schema#label> \"".$developmentContent['name']."\" .		
				<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/effort> \"".$developmentContent['effort']."\" .
				<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/status> \"".$developmentContent['status']."\" .
				<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/optionalDevelopment> \"".$developmentContent['optional']."\" .
				";
		
		if ($developmentContent['projectId'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['projectId']."> <http://www.pmbservices.fr/Property/development> <http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> .
				";
		}
		
		if ($developmentContent['priority'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/priority> <http://www.pmbservices.fr/Dataset/#".$developmentContent['priority']."> .
				";
		}
		
		if ($developmentContent['plannedStart'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/plannedStart> \"".$developmentContent['plannedStart']."\" .
				";
		}
		
		if ($developmentContent['plannedEnd'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/plannedEnd> \"".$developmentContent['plannedEnd']."\" .
				";
		}
		
		if ($developmentContent['earlyStart'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/earlyStart> \"".$developmentContent['earlyStart']."\" .
				";
		}
		
		if ($developmentContent['lateStart'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/lateStart> \"".$developmentContent['lateStart']."\" .
				";
		}
		
		if ($developmentContent['realStart'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/realStart> \"".$developmentContent['realStart']."\" .
				";
		}
		
		if ($developmentContent['earlyEnd'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/earlyEnd> \"".$developmentContent['earlyEnd']."\" .
				";
		}
		
		if ($developmentContent['lateEnd'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/lateEnd> \"".$developmentContent['lateEnd']."\" .
				";
		}
		
		if ($developmentContent['realEnd'] != NULL) {
			$insert .= "<http://www.pmbservices.fr/Dataset/#".$developmentContent['id']."> <http://www.pmbservices.fr/Property/realEnd> \"".$developmentContent['realEnd']."\" .
				";
		}
		
		$insert .= "}";
		
		$this->store->query($insert);
	}
	
	/**
	 * Link a resource to a development
	 * @param array $content
	 */
	public function affectAResource($content) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$content['developmentID']."> <http://www.pmbservices.fr/Property/resource> <http://www.pmbservices.fr/Dataset/#".$content['resourceID']."> .
			}";
		
		$this->store->query($insert);
	}
	
	/**
	 * Tag a development with a skill
	 * @param array $content
	 */
	public function tagADevelopment($content) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$content['developmentID']."> <http://www.pmbservices.fr/Property/skillTag> <http://www.pmbservices.fr/Dataset/#".$content['skillID']."> .
			}";
		
		$this->store->query($insert);
	}
	
	
	
	
	/*
	 * FACTORY QUERY
	 */
	
	/**
	 * Return an array of the store content
	 * 
	 * @param string $type
	 * @return array
	 */
	public function getListOfUri($type = "all") {
		if ($type === "all") {
			$query = "
				SELECT ?s ?o WHERE {
					GRAPH dataG: { ?s rdf:type ?o . }
				}
			";
		} else {
			$query = "
				SELECT ?s WHERE {
					GRAPH dataG: { ?s rdf:type pmbE:".$type." . }
				}
			";
		}
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	
	
	// General
	/**
	 * @param string $uri
	 */
	public function getLabel($uri) {
		$query = "
			SELECT ?l WHERE {
				GRAPH dataG: { pmbData:".$uri." rdfs:label ?l . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getName($uri) {
		$query = "
			SELECT ?n WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:name ?n . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getFirstname($uri) {
		$query = "
			SELECT ?f WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:firstname ?f . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getPriority($uri) {
		$query = "
			SELECT ?p WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:priority ?p . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	

	
	
	// Projects
	/**
	 * @param string $uri
	 */
	public function getProjectCustomer($uri) {
		$query = "
			SELECT ?c WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:customer ?c . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectDevelopersMind($uri) {
		$query = "
			SELECT ?dM WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:developersMind ?dM . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getProjectDevelopments($uri) {
		$query = "
			SELECT ?d WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:development ?d . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//Weighted List
	/**
	 * @param string $uri
	 */
	public function getWLWeight($uri) {
		$query = "
			SELECT ?w WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:weight ?w . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//Skill
	/**
	 * @param string $uri
	 */
	public function getSkillParent($uri) {
		$query = "
			SELECT ?p WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:parentSkill ?p . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//Resource
	/**
	 * @param string $uri
	 */
	public function getResourceSkillEfficiency($uri) {
		$query = "
			SELECT ?sE WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:skillEfficiency ?sE . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceHolidays($uri) {
		$query = "
			SELECT ?h WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:resourceUnavailability ?h . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceDevelopment($uri) {
		$query = "
			SELECT ?d WHERE {
				GRAPH dataG: { ?d pmbP:resource pmbData:".$uri." . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getResourceBaseEfficiency($uri) {
		$query = "
			SELECT ?bE WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:baseEfficiency ?bE . }
			}
		";
		
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//Development
	/**
	 * @param string $uri
	 */
	public function getDevelopmentParent($uri) {
		$query = "
			SELECT ?p WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:parentDevelopment ?p . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPrevious($uri) {
		$query = "
			SELECT ?p WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:previousDevelopment ?p . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentEffort($uri) {
		$query = "
			SELECT ?e WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:effort ?e . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentStatus($uri) {
		$query = "
			SELECT ?s WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:status ?s . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentOptional($uri) {
		$query = "
			SELECT ?o WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:optionalDevelopment ?o . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPlannedStart($uri) {
		$query = "
			SELECT ?pS WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:plannedStart ?pS . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentPlannedEnd($uri) {
		$query = "
			SELECT ?pE WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:plannedEnd ?pE . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentLateStart($uri) {
		$query = "
			SELECT ?lS WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:lateStart ?lS . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentLateEnd($uri) {
		$query = "
			SELECT ?lE WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:lateEnd ?lE . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentEarlyStart($uri) {
		$query = "
			SELECT ?eS WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:earlyStart ?eS . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentEarlyEnd($uri) {
		$query = "
			SELECT ?eE WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:earlyEnd ?eE . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentRealStart($uri) {
		$query = "
			SELECT ?rS WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:realStart ?rS . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentRealEnd($uri) {
		$query = "
			SELECT ?rE WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:realEnd ?rE . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentResources($uri) {
		$query = "
			SELECT ?r WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:resource ?r . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getDevelopmentSkillTags($uri) {
		$query = "
			SELECT ?sT WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:skillTag ?sT . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//SkillEfficiency
	/**
	 * @param string $uri
	 */
	public function getSESkill($uri) {
		$query = "
			SELECT ?s WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:skill ?s . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getSEEfficiency($uri) {
		$query = "
			SELECT ?e WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:skillEfficiency ?e . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//Holidays
	/**
	 * @param string $uri
	 */
	public function getHolidaysStart($uri) {
		$query = "
			SELECT ?s WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:holidaysStart ?s . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getHolidaysEnd($uri) {
		$query = "
			SELECT ?e WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:holidaysEnd ?e . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getHolidaysReason($uri) {
		$query = "
			SELECT ?r WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:holidaysReason ?r . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//CustomerMind
	/**
	 * @param string $uri
	 */
	public function getCMCustomer($uri) {
		$query = "
			SELECT ?c WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:customer ?c . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	/**
	 * @param string $uri
	 */
	public function getCMMind($uri) {
		$query = "
			SELECT ?m WHERE {
				GRAPH dataG: { pmbData:".$uri." pmbP:mindState ?m . }
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	//Other
	/**
	 * @param string $skillUri
	 */
	public function getResourceWithSkill($skillUri) {
		$query = "
			SELECT ?r WHERE {
				GRAPH dataG: {
					?s pmbP:skill pmbData:".$uri." .
					?r pmbP:skillEfficiency ?s
					?r rdf:type pmbE:Resource .
				}
			}
		";
	
		$rawResult = $this->store->query($this->PREFIX.$query);
		return $rawResult['result']['rows'];
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Add a personalized priority
	 * 
	 * @param array $priorityContent
	 */
	public function insertPriority($priorityContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$priorityContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/Priority> .
				<http://www.pmbservices.fr/Dataset/#".$priorityContent['id']."> <http://www.w3.org/2000/01/rdf-schema#label> \"".$priorityContent['name']."\" .
				<http://www.pmbservices.fr/Dataset/#".$priorityContent['id']."> <http://www.pmbservices.fr/Property/weight> \"".$priorityContent['weight']."\" .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a personalized mind state
	 * 
	 * @param array $mindStateContent
	 */
	public function insertMindState($mindStateContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$mindStateContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/MindState> .
				<http://www.pmbservices.fr/Dataset/#".$mindStateContent['id']."> <http://www.w3.org/2000/01/rdf-schema#label> \"".$mindStateContent['name']."\" .
				<http://www.pmbservices.fr/Dataset/#".$mindStateContent['id']."> <http://www.pmbservices.fr/Property/weight> \"".$mindStateContent['weight']."\" .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Add a customer mind state
	 * 
	 * @param array $customerMindContent
	 */
	public function insertCustomerMind($customerMindContent) {
		$insert = "
			INSERT INTO <http://www.pmbservices.fr/Dataset/> {
				<http://www.pmbservices.fr/Dataset/#".$customerMindContent['id']."> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.pmbservices.fr/Entity/CustomerMind> .
				<http://www.pmbservices.fr/Dataset/#".$customerMindContent['id']."> <http://www.pmbservices.fr/Property/client> <http://www.pmbservices.fr/Dataset/#".$customerMindContent['customer']."> .
				<http://www.pmbservices.fr/Dataset/#".$customerMindContent['id']."> <http://www.pmbservices.fr/Property/mindState> <http://www.pmbservices.fr/Dataset/#".$customerMindContent['mind']."> .
			}
			";
		
		$this->store->query($insert);
	}
	
	/**
	 * Delete all triples concernig the uri
	 * 
	 * @param string $uri
	 */
	public function deleteData($uri) {
		$delete = "
			DELETE FROM <http://www.pmbservices.fr/Dataset/> {
				pmbData:".$uri." ?p ?o .
			}
			";
		
		$this->store->query($this->PREFIX.$delete);
	}
}