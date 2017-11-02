<?php
require_once 'controllers/DataController.class.php';
require_once 'connectors/DataRequest.class.php';

class TaskCalculator {
	
	/**
	 * @var DataController
	 */
	private static $dc;
	
	/**
	 * Instance an new DataController
	 */
	private static function getController() {
		self::$dc = new DataController(new DataRequest());
	}
	
	/**
	 * @param string $s
	 * @param string $e
	 * @return array
	 */
	public static function getWeekEnd($s, $e) {
		$end = new DateTime($e);
		$endTimestamp = $end->getTimestamp();
	
		$start = new DateTime($s);
		$start->setTime(0,0);
		while (($start->format("l") != "Saturday") && ($start->format("l") != "Sunday")) {
			$d = $start->setTimestamp($start->getTimestamp() + 24*60*60);
		}
	
		$d = $start;
	
		$oneday = new DateInterval("P1D");
		$sixdays = new DateInterval("P6D");
		$res = array();
		while ($d->getTimestamp() <= $endTimestamp) {
			$res[] = $d->format("Y-m-d");
			$d = $d->add($oneday);
			if ($d->getTimestamp() <= $endTimestamp) {
				$res[] = $d->format("Y-m-d");
			}
			$d = $d->add($sixdays);
		}
	
		for ($i = 0; $i < sizeof($res); $i++) {
			$res[$i] = strtotime($res[$i]);
		}
	
		return $res;
	
	}
	
	/**
	 * @param array $dev
	 * @param array $res
	 * @return boolean
	 */
	public static function isHolidays($dev, $res) {
		$date = array("real", "planned", "early", "late");
		
		foreach ($date as $d) {
			if (isset($dev[$d."Start"]) && isset($dev[$d."End"])) {
				
				for ($i = 0; $i < sizeof($res['holidays']); $i++) {
					$vac = self::$dc->getHolidays($res['holidays'][$i]);
					if (strtotime($vac['beginning']) < strtotime($dev[$d."Start"])) {
						if (strtotime($vac['ending']) < strtotime($dev[$d."Start"])) {
							continue;
						} else {
							return true;
						}
					} else if (strtotime($vac['beginning']) > strtotime($dev[$d."End"])) {
						if (strtotime($vac['ending']) > strtotime($dev[$d."End"])) {
							continue;
						} else {
							return true;
						}
					} else {
						return true;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * @param array $dev
	 * @param array $arrayRes
	 * @return boolean|number
	 */
	public static function calculateAverage($dev, $arrayRes) {
		if (!isset(self::$dc)) {
			self::getController();
		}
		
		$moy = 0;
		$cpt = 0;
		foreach ($arrayRes as $r) {
			if (!self::isHolidays($dev, $r)) {
				$moy += $r['baseEfficiency'];
				$cpt++;
			}
		}
		
		if ($cpt == 0) {
			return false;
		}
		
		$moy = $moy / $cpt;
		
		$result = ($dev['effort']/$cpt)/$moy;
		//$result = $result / self::$dc->getAPriority($dev['priority'])['weight'];
		//$result = $result / self::$dc->getAMind(self::$dc->getACustomerMind($projet['customer'])['mind'])['weight'];
		//$result = $result / self::$dc->getAMind($projet['developersMind'])['weight'];
		$result = ceil($result)*24*60*60;
		
		$res = self::getWeekEnd($dev["plannedStart"], $dev["plannedEnd"]);
		foreach ($res as $r) {
			if ((strtotime($dev["plannedStart"]) <= $r) && (strtotime($dev["plannedEnd"]) >= $r)) {
				$result += 24*60*60;
			}
		}
		
		return $result;
	}
	
	/**
	 * @param array $arraySkill
	 * @param array $dev
	 * @param array $arrayRes
	 * @return boolean|number
	 */
	public static function calculateWithSkillAverage($arraySkill, $dev, $arrayRes) {
		if (!isset(self::$dc)) {
			self::getController();
		}
		
		$moy = 0;
		$complete = 0;
		
		for ($i = 0; $i < sizeof($arrayRes); $i++) {
			for ($j = 0; $j < sizeof($arrayRes[$i]['skillEfficiency']); $j++) {
				if (array_search(self::$dc->getSkillEfficiency($arrayRes[$i]['skillEfficiency'][$j])['skill'], $arraySkill) !== false) {
					$complete++;
					$moy += self::$dc->getSkillEfficiency($arrayRes[$i]['skillEfficiency'][$j])['efficiency'];
				}
			}
		}
		
		if ($complete === 0) {
			return false;
		}
		
		$moy = $moy / (sizeof($arrayRes) * sizeof($arraySkill));
		
		// résultat cohérent
		$result = ($dev['effort']/sizeof($arrayRes))/$moy;
		//$result = $result / self::$dc->getAPriority($dev['priority'])['weight'];
		//$result = $result / self::$dc->getAMind(self::$dc->getACustomerMind($projet['customer'])['mind'])['weight'];
		//$result = $result / self::$dc->getAMind($projet['developersMind'])['weight'];
		$result = ceil($result)*24*60*60;
		
		$res = self::getWeekEnd($dev["plannedStart"], $dev["plannedEnd"]);
		foreach ($res as $r) {
			if ((strtotime($dev["plannedStart"]) <= $r) && (strtotime($dev["plannedEnd"]) >= $r)) {
				$result += 24*60*60;
			}
		}
		
		return $result;
	}
}