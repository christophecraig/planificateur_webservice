<?php
require_once 'controllers/DataController.class.php';
require_once 'connectors/DataRequest.class.php';
require_once 'controllers/ResourceProcessing.class.php';

class TaskSelector {
	
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
	 * @param array $resources
	 * @param int $number
	 * @return array
	 */
	public static function takeBestResourcesAverage($resources, $number) {
		$array2 = array();
		foreach ($resources as $r) {
			$array2[$r['id']] = $r['baseEfficiency'];
		}
		$array = array_values($array2);
		ResourceProcessing::heap_sort($array);
		
		$response = array();
		foreach ($resources as $r)  {
			switch ($number) {
				case 1:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					break;
					
				case 2:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[sizeof($array)-2], $array2) == $r['id']) {
						$response[1] = $r;
					}
					break;
					
				case 4:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[sizeof($array)-2], $array2) == $r['id']) {
						$response[1] = $r;
					}
					if (array_search($array[sizeof($array)-3], $array2) == $r['id']) {
						$response[2] = $r;
					}
					if (array_search($array[sizeof($array)-4], $array2) == $r['id']) {
						$response[3] = $r;
					}
					break;
				
				default:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[sizeof($array)-2], $array2) == $r['id']) {
						$response[1] = $r;
					}
					break;
			}
			
		}
		
		return $response;
	}
	
	/**
	 * @param array $resources
	 * @param int $number
	 * @return array
	 */
	public static function takeWorstResourcesAverage($resources, $number) {
		$array2 = array();
		foreach ($resources as $r) {
			$array2[$r['id']] = $r['baseEfficiency'];
		}
		$array = array_values($array2);
		ResourceProcessing::heap_sort($array);
		
		$response = array();
		foreach ($resources as $r) {
			switch ($number) {
				case 1:
					if (array_search($array[0], $array2) == $r['id']) {
						$response[0] = $r;
					}
					break;
				
				case 2:
					if (array_search($array[0], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[1], $array2) == $r['id']) {
						$response[1] = $r;
					}
					break;
				
				case 4:
					if (array_search($array[0], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[1], $array2) == $r['id']) {
						$response[1] = $r;
					}
					if (array_search($array[2], $array2) == $r['id']) {
						$response[2] = $r;
					}
					if (array_search($array[3], $array2) == $r['id']) {
						$response[3] = $r;
					}
					break;
				
				default:
					if (array_search($array[0], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[1], $array2) == $r['id']) {
						$response[1] = $r;
					}
					break;
			}
			
		}
		
		return $response;
	}
	
	/**
	 * @param array $resources
	 * @param int $number
	 * @param array $arraySkill
	 * @return array
	 */
	public static function takeBestResourcesSkill($resources, $number, $arraySkill) {
		$array2 = array();
		foreach ($resources as $r) {
			$array2[$r['id']] = $r['baseEfficiency'];
		}
		$array = array_values($array2);
		ResourceProcessing::heap_sort($array);
	
		$response = array();
		foreach ($resources as $r) {
			switch ($number) {
				case 1:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					break;
					
				case 2:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[sizeof($array)-2], $array2) == $r['id']) {
						$response[1] = $r;
					}
					break;
					
				case 4:
					
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					}
					if (array_search($array[sizeof($array)-2], $array2) == $r['id']) {
						$response[1] = $r;
					}
					if (array_search($array[sizeof($array)-3], $array2) == $r['id']) {
						$response[2] = $r;
					}
					if (array_search($array[sizeof($array)-4], $array2) == $r['id']) {
						$response[3] = $r;
					}
					break;
				
				default:
					if (array_search($array[sizeof($array)-1], $array2) == $r['id']) {
						$response[0] = $r;
					if (array_search($array[sizeof($array)-2], $array2) == $r['id']) {
						$response[1] = $r;
					}
					}
					break;
			}
		}
	
		return $response;
	}
	
	/**
	 * @param array $resources
	 * @param int $number
	 * @param array $arraySkill
	 * @return array
	 */
	public static function takeWorstResourcesSkill($resources, $number, $arraySkill) {
		if (!isset(self::$dc)) {
			self::getController();
		}
		
		$response = array(); $temp_res = array();
		foreach ($resources as $r) {
			$have = false;
			$sum = array();
			for ($j = 0; $j < sizeof($r['skillEfficiency']); $j++) {
				$se = self::$dc->getSkillEfficiency($r['skillEfficiency'][$j]);
				if (array_search($se['skill'], $arraySkill) !== false) {
					$sum[sizeof($sum)] = $se['efficiency'];
					$have = true;
				}
			}
			if (!$have) {
				continue;
			} else {
				$temp_res[$r['id']] = array_sum($sum)/sizeof($arraySkill);
			}
		}
		$sort = array_values($temp_res);
		ResourceProcessing::heap_sort($sort);
		
		$re = 0;
		foreach ($resources as $r) {
			if (sizeof($response) == $number) {
				break;
			} else {
				if (array_search($sort[$re], $temp_res) == $r['id']) {
					$response[$re] = $r;
					
					echo $re;
				}
			}
			$re++;
		}
		
		return $response;
	}
}