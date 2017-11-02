<?php
/**
 * @author mbeacco
 *
 */
class ResourceProcessing {
	
	/**
	 * We did it (delete) the URL
	 * @param string $string
	 * @return string
	 */
	public static function withoutURL($string) {
		if (preg_match("#\/rdf-schema\##", $string)) {
			$temp = explode('http://www.w3.org/2000/01/rdf-schema#', $string);
			return "rdfs:".$temp[1];
		} else if (preg_match("#\/22-rdf-syntax-ns\##", $string)) {
			$temp = explode('http://www.w3.org/1999/02/22-rdf-syntax-ns#', $string);
			return "rdf:".$temp[1];
		} else if (preg_match("#\/xmlschema11-2\/#", $string)) {
			$temp = explode('https://www.w3.org/TR/xmlschema11-2/#', $string);
			return "xsd:".$temp[1];
		} else if (preg_match("#\/Entity\/#", $string)) {
			$temp = explode('http://www.pmbservices.fr/Entity/', $string);
			return $temp[1];
		} else if (preg_match("#\/Property\/#", $string)) {
			$temp = explode('http://www.pmbservices.fr/Property/', $string);
			return $temp[1];
		} else if (preg_match("#\/Dataset\/#", $string)) {
			$temp = explode('http://www.pmbservices.fr/Dataset/#', $string);
			return $temp[1];
		} else {
			return $string;
		}
	}
	
	/**
	 * Convert a date in FR format to US format
	 * @param string $date
	 * @return string
	 */
	public static function dateFRtoUS($date) {
		if (preg_match("#[0-3][0-9]\/[0-1][0-9]\/[1-9][0-9][0-9][0-9]#", $date)) {
			$tab_temp = explode('/', $date);
			$day = $tab_temp[0];
			$tab_temp[0] = $tab_temp[2];
			$tab_temp[2] = $day;
			$date = implode('-', $tab_temp);
			unset($day, $tab_temp);
			return $date;
		} else {
			return $date;
		}
	}
	
	/**
	 * Convert a date in US format to FR format
	 * @param string $date
	 * @return string
	 */
	public static function dateUStoFR($date) {
		if (preg_match("#[1-9][0-9][0-9][0-9]-[0-1][0-9]-[0-3][0-9]#", $date)) {
			$tab_temp = explode('-', $date);
			$day = $tab_temp[0];
			$tab_temp[0] = $tab_temp[2];
			$tab_temp[2] = $day;
			$date = implode('/', $tab_temp);
			unset($day, $tab_temp);
			return $date;
		} else {
			return $date;
		}
	}
	
	/**
	 * For the heap_sort method
	 * @param array $array
	 * @param int $i
	 * @param int $t
	 */
	private static function build_heap(&$array, $i, $t){
		$tmp_var = $array[$i];
		$j = $i * 2 + 1;
	
		while ($j <= $t)  {
			if($j < $t)
				if($array[$j] < $array[$j + 1]) {
					$j = $j + 1;
				}
			if($tmp_var < $array[$j]) {
				$array[$i] = $array[$j];
				$i = $j;
				$j = 2 * $i + 1;
			} else {
				$j = $t + 1;
			}
		}
		$array[$i] = $tmp_var;
	}
	
	/**
	 * Sort an array with the heap method
	 * @param array $array
	 */
	public static function heap_sort(&$array) {
		//This will heapify the array
		$init = (int)floor((count($array) - 1) / 2);
		// Thanks jimHuang for bug report
		for($i=$init; $i >= 0; $i--){
			$count = count($array) - 1;
			self::build_heap($array, $i, $count);
		}
	
		//swaping of nodes
		for ($i = (count($array) - 1); $i >= 1; $i--)  {
			$tmp_var = $array[0];
			$array [0] = $array [$i];
			$array [$i] = $tmp_var;
			self::build_heap($array, 0, $i - 1);
		}
	}
}