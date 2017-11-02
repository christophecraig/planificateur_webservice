<?php
//encodage iso-8859-1

/*
 * La fonction str_split ne fonctionnant que en ISO-8859-1, elle a été déplacée dans ce fichier.
 * Elle permet de renvoyer un tableau de caractères à partir d'une chaine. 
 */
function str_totab($str) {
	$str = utf8_decode($str);
	
	$string3 = str_split($str);
	
	for ($i = 0; $i < strlen($str); $i++) {
		$c = $string3[$i];
		$c = utf8_encode($c);
		$string3[$i] = $c;
	}

	return $string3;
}

/*
 * La fonction trim et ses descendants rtrim et ltrim ne fonctionnants que en ISO-8859-1,
 * elles ont été déplacées dans ce fichier.
 * La fonction trim enlève un caractère passé en paramètre au début et en fin de chaine.
 * 
 * Ici nous enlevons les apostrophes.
 */
function str_to_noquote($str) {
	$str = trim(utf8_decode($str),'\'');
	return utf8_encode($str);
}

/*
 * Ici ce sont les tirets simples qui sont enlevés.
 */
function str_to_nohyphen($str) {
	$str = trim(utf8_decode($str),'-');
	return utf8_encode($str);
}

/*
 * En cas d'espaces en début et fin de chaine, ils sont enlevés.
 */
function str_to_nospace($str) {
	$str = trim(utf8_decode($str),' ');
	return utf8_encode($str);
}

/*
 * Cette fonction est utilisée dans le cas où un espace est détecté à un emplacement indésirable.
 */
function str_to_nospace_right($str) {
	$str = ltrim(utf8_decode($str),' ');
	return utf8_encode($str);
}
?>