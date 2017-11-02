<?php
/**
 * @author mbeacco
 * Holidays class, to give some holidays to yous developers
 */
class Holidays {
	
	/**
	 * Holidays id
	 * @var string
	 */
	private $id;
	
	/**
	 * Holidays end
	 * La ressource associée aura un état d'esprit catastrophique et une efficacité quasiment nulle le jour de son retour.
	 * Ces deux paramètres remonteront doucement dans les 2-3 jours qui suivent.
	 * @var string
	 */
	private $end;
	
	/**
	 * Holidays start
	 * Quit your place earliest as possible
	 * @var string
	 */
	private $start;
	
	/**
	 * Holidays reason
	 * @var String
	 */
	private $reason;
	
	/**
	 * @var Factory
	 */
	private static $factory;
	
	/**
	 * Construc the holidays period
	 * @param string $id
	 * @param DataRequest $bdd
	 */
	public function __construct($id, $bdd, $o = NULL) {
		$this->id = $id;
		
		if (!isset(self::$factory)) {
			self::$factory = Factory::getInstance($bdd);
		}
		
		if (isset($o)) {
			$this->start = $o['begin'];
			$this->end = $o['end'];
			$this->reason = $o['why'];
		}
	}
	
	/**
	 * Get the holidays id
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set the holidays id
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Set the start of your holidays
	 * Si elle est avancée, la ressource est contente, sinon elle boude.
	 * @param DateTime $d
	 */
	public function setStart() {
		$this->start = self::$factory->getHolidaysStart($this->id);
	}
	
	/**
	 * Modifie la date de retour de vacances.
	 * Si elle est retardée la ressource est contente, sinon elle boude.
	 * @param DateTime $f
	 */
	public function setEnd() {
		$this->end = self::$factory->getHolidaysEnd($this->id);
	}
	
	/**
	 * Modifie le reason des vacances.
	 * Le plus souvent "Vacances en famille" (enfin j'espère)
	 * @param string $m
	 */
	public function setReason() {
		$this->reason = self::$factory->getHolidaysReason($this->id);
	}
	
	/**
	 * 
	 */
	public function setHolidays() {
		$this->setStart();
		$this->setEnd();
		$this->setReason();
	}
	
	/**
	 * Return a representation of a Holidays object
	 * @return array
	 */
	public function getHolidays() {
		return array(
				"id" => $this->id,
				"beginning" => $this->start,
				"ending" => $this->end,
				"reason" => $this->reason,
		);
	}
}