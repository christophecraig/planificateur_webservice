<?php
//encodage iso-8859-1

/*
 * La fonction str_split ne fonctionnant que en ISO-8859-1, elle a �t� d�plac�e dans ce fichier.
 * Elle permet de renvoyer un tableau de caract�res � partir d'une chaine. 
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
 * elles ont �t� d�plac�es dans ce fichier.
 * La fonction trim enl�ve un caract�re pass� en param�tre au d�but et en fin de chaine.
 * 
 * Ici nous enlevons les apostrophes.
 */
function str_to_noquote($str) {
	$str = trim(utf8_decode($str),'\'');
	return utf8_encode($str);
}

/*
 * Ici ce sont les tirets simples qui sont enlev�s.
 */
function str_to_nohyphen($str) {
	$str = trim(utf8_decode($str),'-');
	return utf8_encode($str);
}

/*
 * En cas d'espaces en d�but et fin de chaine, ils sont enlev�s.
 */
function str_to_nospace($str) {
	$str = trim(utf8_decode($str),' ');
	return utf8_encode($str);
}

/*
 * Cette fonction est utilis�e dans le cas o� un espace est d�tect� � un emplacement ind�sirable.
 */
function str_to_nospace_right($str) {
	$str = ltrim(utf8_decode($str),' ');
	return utf8_encode($str);
}
?>