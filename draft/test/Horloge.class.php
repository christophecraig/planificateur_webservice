<?php
/**
 * @author mbeacco
 *
 */
class Horloge {
	
	/**
	 * @var string
	 */
	private $formatDate;
	
	/**
	 * @var string
	 */
	private $formatHeure;
	
	/**
	 * @param string $formatDate
	 * @param string $formatHeure
	 */
	public function __construct($formatDate, $formatHeure) {
		$this->formatDate = $formatDate;
		$this->formatHeure = $formatHeure;
	}
	
	/**
	 * @return string
	 */
	public function getDate() {
		return date($this->formatDate);
	}
	
	/**
	 * @return string
	 */
	public function getHeure() {
		return date($this->formatHeure);
	}
	
	/**
	 * @param string $formatDate
	 */
	public function setFormatDate($formatDate) {
		$this->formatDate = $formatDate;
	}
	
	/**
	 * @param string $formatHeure
	 */
	public function setFormatHeure($formatHeure) {
		$this->formatHeure = $formatHeure;
	}
}