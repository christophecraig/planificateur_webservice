<?php
require_once './ontology/Ontology.class.php';
require_once './connectors/OntoRequest.class.php';
/**
 * @author mbeacco
 *
 */
class OntologyController {
	
	/**
	 * Variable contenant la connection à la bdd
	 * @var OntoRequest
	 */
	public $bdd;
	
	/**
	 * Contient l'ontologie à afficher
	 * @var Ontology
	 */
	public $ontology;
	
	/**
	 * On veut casser mon application... :( Méchant ! :'(
	 * @var string
	 */
	private $HACK = "<p>You're a fucking asshole you know?<br>
					Click <a href=\"./\">here</a> and stop trying to crack my app!</p>";
	
	/**
	 * Construction de l'instance du connecteur à la bdd
	 */
	public function __construct() {
		$this->bdd = new OntoRequest();
	}
	
	/**
	 * Setting the ontology after you've built it in index.php
	 * @param Ontology $ontology
	 */
	public function setOntology($ontology) {
		$this->ontology = $ontology;
	}
	
	/**
	 * On renvoie l'arbre pour faire joli
	 * @param array $demand
	 * @return array
	 */
	protected function getTree($demand) {
		$tree = array();
		
		if (empty($demand['type'])) {
			foreach ($this->ontology->Entity as $entity) {
				$tree[$entity->getNom()]['nom'] = $entity->getNom();
			}
			return $tree;
		}
		
		switch ($demand['type']) {
			case 'Entity':
				foreach ($this->ontology->Entity as $entity) {
					$tree[$entity->getNom()]['nom'] = $entity->getNom();
				}
				// On prends les properties de l'entity
				foreach ($this->ontology->Entity[$demand['value']]->propertyList as $property) {
					$tree[$demand['value']]['propertyList'][$property->getNom()]['nom'] = $property->getNom();
				}
				break;
			
			case 'Property':
				foreach ($this->ontology->Entity as $entity) {
					$tree[$entity->getNom()]['nom'] = $entity->getNom();
				}
				//On ouvre toutes les entities qui concernent la property
				foreach ($this->ontology->Property[$demand['value']]->domain as $entity) {
					$tree[$entity->getNom()]['propertyList'][$demand['value']]['nom'] = $demand['value'];
				}
				break;
			
			default:
				foreach ($this->ontology->Entity as $entity) {
					$tree[$entity->getNom()]['nom'] = $entity->getNom();
				}
				break;
		}
		
		return $tree;
	}
	
	/**
	 * On va chercher ce qu'il faut
	 * @param array $demand
	 * @return Ontology
	 */
	protected function getOntology($demand) {
			/*$onto = array();
			$onto['Tree'] = $this->getTree($demand);
			return $onto;*/
		
			$onto = $this->ontology->$demand['type'];
			//var_dump($onto);
			$onto = $onto[$demand['value']];
			return $onto;
		
	}
	
	/**
	 * On va chercher le bon template
	 * @param array $demand
	 */
	protected function getTemplate($demand) {
		if (empty($demand['type'])) {
			return 'layout_index.html';
		}
		switch ($demand['type']) {
			case 'Entity' :
				/*
				 * Doing something
				 */
				return 'layout_entity.html';
			case 'Property' :
				/*
				 * Doing something
				 */
				return 'layout_property.html';
			default :
				/*
				 * Doing something
				 */
				return 'layout_index.html';
		}
	}
	
	/**
	 * On donne le bon contenu de la page
	 * @param array $demand
	 */
	public function getPage($demand) {
		$rendu = array();
		
		/*
		 * On vérifie si c'est vide (page d'accueil)
		 */
		if (empty($demand)) {
			$template = $this->getTemplate($demand);
			$rendu['Tree'] = $this->getTree($demand);
			
		/*
		 * Si c'est pas vide c'est qu'on va chercher une entité ou une propriété
		 */
		} else if (($demand['type'] == 'Entity') || ($demand['type'] == 'Property')) {
			//On initialise la variable de contrôle
			$good = false;
			
			/*
			 * Si c'est une entité, on check si le nom de l'entité demandée est dans le tableau des entités
			 */
			if ($demand['type'] == 'Entity') {
				foreach ($this->ontology->Entity as $entity) {
					if ($demand['value'] == $entity->getNom()) {
						$good = true;
						break;
					}
				}
				
			/*
			 * Si c'est une propriété, on check si le nom de la propriété demandée est dans le tableau des propriétés
			 */
			} else {
				foreach ($this->ontology->Property as $property) {
					if ($demand['value'] == $property->getNom()) {
						$good = true;
						break;
					}
				}
			}
			
			/*
			 * On teste si le contrôle s'est bien passé et si c'est le cas on affiche la page
			 */
			if ($good) {
				$template = $this->getTemplate($demand);
				$rendu[$demand['type']] = $this->getOntology($demand);
				$rendu['Tree'] = $this->getTree($demand);
				
			/*
			 * Sinon c'est qu'on veut casser mon application... :( Méchant ! :'(
			 */
			} else {
				echo $this->HACK;
			}
			
		/*
		 * Sinon c'est qu'on veut casser mon application... :( Méchant ! :'(
		 */
		} else {
			echo $this->HACK;
		}
		
		if (isset($demand['dataset'])) {
			$rendu['data'] = $demand['dataset'];
			$rendu['data']['state'] = true;
		}
		
		/*
		 * Et on vérifie enfin si le tableau de rendu est bien rempli
		 */
		if (!empty($rendu)) {
			$h2o = new H2O('../templates/'.$template, array("loader"=>'file'));
			echo $h2o->render($rendu);
		}
		
	}
}