<?php 
$_SESSION['erreur'] = null;
$_SESSION['erreur'] = "";

//encodage utf-8
	
include 'func_txt_maxime.php';

/*
 * Cette fonction enlève les caractères spéciaux contenus dans le nom ou tout autre texte
 * dont toutes les lettres sont en majuscule.
 */
function fl_maj_nom($ch) {
	
	/*
	 * On corrige les noms composés s'il reste des accents ou des espaces superflus
	 * entre les tirets simples.
	 */
	$ch = explode("-", $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		$ch[$i] = str_to_nospace($ch[$i]);
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		$ch[$i] = strtoupper(strtolower($ch[$i]));
	}
	$ch = implode("-",$ch);
	
	/*
	 * On détecte les doubles tirets et on corrige les éventuels espaces ou caractère encores accentué.
	 * Si plus d'un double tiret est détecté, un message d'éreur s'enregistre.
	 */
	$ch = explode("--", $ch);
	if (sizeof($ch) > 2) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Le double tiret n'est autoris&eacute; qu'une seule fois dans un nom !<br>";
	} else {
		for($i = 0; $i < sizeof($ch); $i ++){
			$ch[$i] = str_to_nospace($ch[$i]);
			$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
			$ch[$i] = strtoupper(strtolower($ch[$i]));
		}
	}
	$ch = implode("--",$ch);
	
	/*
	 * Nous faisons de même avec les apostrophes simples.
	 * Si une apostrophe double est détectée, elle est remplacée par une simple.
	 */
	$ch = preg_replace('/\'+/', '\'', $ch);
	$ch = explode('\'', $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		if ($ch[$i] != " ") {
			$ch[$i] = str_to_nospace_right($ch[$i]);
		}
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		$ch[$i] = strtoupper($ch[$i]);
	}
	$ch = implode('\'',$ch);
	
	/*
	 * Ainsi que pour les noms composés séparés par un ou plusieurs espaces
	 */
	$ch = preg_replace('/\s\s+/', ' ', $ch);
	$ch = explode(' ', $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		$ch[$i] = strtoupper($ch[$i]);
	}
	$ch = implode(' ',$ch);
	
	//if (preg_match('#\'#', $ch)) {
	$ch = str_to_noquote($ch);
	//} else if (preg_match('#-+#', $ch)) {
	$ch = str_to_nohyphen($ch);
	//}
	//if (empty($test1) XOR empty($test2)) {
		//$_SESSION['erreur'] = $_SESSION['erreur']."Ce caract&egrave;re seul est interdit ! nom : ".$ch."<br>";
	//}
	
	/*
	 * On vérifie que la longueur de la chaine est inférieure à 30 caractères.
		 * Egalement que les triples tirets, les tirets longs et autres caractères
		 * interdits sont absents dans la chaine. 
	 */
	if (sizeof(str_totab($ch)) > 30) {
		$_SESSION['erreur'] = $_SESSION['erreur']."R&eacute;duisez le nombre de lettres !<br>";
	}
	if (preg_match('#---#', $ch) OR preg_match('#—#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Le triple tiret et le tiret long sont interdits !<br>";
	}
	if (preg_match('#"#', $ch) OR preg_match('#\'\'#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Les guillements et les doubles apostrophes sont interdits !<br>";
	}
	if (preg_match('#\\\#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."L'anti-slash est interdit !<br>";
	}
	if (sizeof(explode("'", $ch)) > 2) {
		$ch = str_to_noquote($ch);
	}
	if (preg_match('#€+|!+|\\+|[0-9]+#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Un caract&egrave;re interdit a &eacute;t&eacute; d&eacute;tect&eacute; !<br>";
	}
	
	$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
	
	return $ch;
}

/*
 * Cette fonction enlève les caractères spéciaux contenus dans le prénom ou tout autre texte
 * dont la première lettre de chaque mot est une majuscule.
 */
function fl_maj_prenom($ch) {
	
	/*
	 * On détecte les doubles tirets interdits dans un prénom
	 */
	if (preg_match('#--#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Le double tiret est interdit dans un pr&eacute;nom !<br>";
	}
	
	/*
	 * On corrige les prénoms composés s'il reste des accents ou des espaces superflus
	 * entre les tirets.
	 */
	$ch = explode("-", $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		$ch[$i] = str_to_nospace($ch[$i]);
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		$ch[$i] = ucfirst(strtolower($ch[$i]));
	}
	$ch = implode("-",$ch);

	/*
	 * Nous faisons de même avec les apostrophes simples.
	 */
	$ch = explode('\'', $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		if ($ch[$i] != " ") {
			$ch[$i] = str_to_nospace_right($ch[$i]);
		}
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		$ch[$i] = ucfirst($ch[$i]);
	}
	$ch = implode('\'',$ch);

	/*$ch = explode('  ', $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		//$ch[0] = str_to_noaccent($ch[0]);
		$ch[$i] = ucfirst($ch[$i]);
	}
	$ch = implode(' ',$ch);*/
	
	/*
	 * Ainsi que pour les prénoms composés séparés par un ou plusieurs espaces
	 */
	$ch = explode(' ', $ch);
	for($i = 0; $i < sizeof($ch); $i ++){
		$ch[$i] = str_tonoa2(str_totab($ch[$i]), $ch[$i]);
		//$ch[0] = str_to_noaccent($ch[0]);
		$ch[$i] = ucfirst($ch[$i]);
	}
	$ch = implode(' ',$ch);
	
	$ch = preg_replace('/\s\s+/', ' ', $ch);
	
	//if (preg_match('#\'#', $ch)) {
		$ch = str_to_noquote($ch);
	//} else if (preg_match('#-#', $ch)) {
		$ch = str_to_nohyphen($ch);
	//}
	//if (empty($test1) XOR empty($test2)) {
		//$_SESSION['erreur'] = $_SESSION['erreur']."Ce caract&egrave;re seul est interdit ! prenom : ".$ch."<br>";
	//}
	
	/*
	 * On vérifie que la longueur de la chaine est inférieure à 30 caractères.
	 * Egalement que les triples tirets, les tirets longs et autres caractères
	 * interdits sont absents dans la chaine. 
	 */
	if (sizeof(str_totab($ch)) > 30) {
		$_SESSION['erreur'] = $_SESSION['erreur']."R&eacute;duisez le nombre de lettres !<br>";
	}
	if (preg_match('#---#', $ch) OR preg_match('#—#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Le triple tiret et le tiret long sont interdits !<br>";
	}
	if (preg_match('#"#', $ch) OR preg_match('#\'\'#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Les guillements et les doubles apostrophes sont interdits !<br>";
	}
	if (preg_match('#\\\#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."L'anti-slash est interdit !<br>";
	}
	if (sizeof(explode("'", $ch)) > 2) {
		$ch = str_to_noquote($ch);
	}
	if (preg_match('#€+|!+|\\+|[0-9]+#', $ch)) {
		$_SESSION['erreur'] = $_SESSION['erreur']."Un caract&egrave;re interdit a &eacute;t&eacute; d&eacute;tect&eacute; !<br>";
	}

	return $ch;
}

/*
 * Cette fonction vérifie que le nombre passé en paramètre est bien un nombre.
 */
function checkInputNumber($num) {
	return is_numeric($num);
}

/*
 * Cette fonction vérifie que le nombre passé en paramètre est bien un réel flottant.
 */
function checkInputFloat($f) {
	return is_float($f);
}

/*
 * Cette fonction vérifie que le nombre passé en paramètre est bien un réel double.
 */
function checkInputDouble($d) {
	return is_double($d);
}

/*
 * Cette fonction vérifie que le nombre passé en paramètre est bien un entier.
 */
function checkInputInteger($int) {
	return is_integer($int);
}

/*function str_tonoa($str) {
	$string3 = $str;
	$tab1 = array('é', 'è', 'ê', 'ë', 'à', 'â', 'ï', 'î', 'ö', 'ü', 'ù', 'œ', 'æ');
	$tab2 = array('e', 'e', 'e', 'e', 'a', 'a', 'i', 'i', 'o', 'u', 'u', 'oe', 'ae');
	$string4 = str_replace($tab1,$tab2, $string3);
	
	//$string5 = strtoupper($string4);
	
	return $string5;
}*/

/*
 * Cette fonction convertit les caractères accentués en caractères sans accents.
 */
function str_tonoa2($tab, $str) {
	$string3 = $tab;
	$tab1 = array('é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë', 'à', 'â', 'À', 'Â', 'ï', 'î', 'Ï', 'Î', 'ö', 'Ö', 'ü', 'ù', 'Ü', 'Ù', 'œ', 'æ', 'Œ', 'Æ', 'ø', 'ñ');
	$tab2 = array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'u', 'oe', 'ae', 'oe', 'ae', 'o', 'n');
	$tab3 = array('É', 'È', 'Ê', 'Ë', 'À', 'Â', 'Ï', 'Î', 'Ö', 'Ü', 'Ù', 'œ', 'æ', 'Œ', 'Æ', 'ø', 'ñ');
	$tab4 = array('é', 'è', 'ê', 'ë', 'à', 'â', 'ï', 'î', 'ö', 'ü', 'ù', 'oe', 'ae', 'oe', 'ae', 'o', 'n');
	for ($i = 0; $i < strlen(utf8_decode($str)); $i++) {
		if ($i == 0) {
			$string4[0] = str_replace($tab1, $tab2, $string3[0]);
		} else {
			$string4[$i] = str_replace($tab3, $tab4, $string3[$i]);
		}
	}

	$string5 = @implode($string4);

	return $string5;
}

/*
 * Cette fonctions, adaptée aux noms, retire tous les accents, les cédilles et les doubles caractères.
 */
function str_to_noaccent_nom($str){
	$str = preg_replace('#Ç#', 'C', $str);
	$str = preg_replace('#ç#', 'c', $str);
	$str = preg_replace('#è|é|ê|ë#', 'e', $str);
	$str = preg_replace('#È|É|Ê|Ë#', 'E', $str);
	$str = preg_replace('#à|á|â|ã|ä|å#', 'a', $str);
	$str = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $str);
	$str = preg_replace('#ì|í|î|ï#', 'i', $str);
	$str = preg_replace('#Ì|Í|Î|Ï#', 'I', $str);
	$str = preg_replace('#ð|ò|ó|ô|õ|ö|ø#', 'o', $str);
	$str = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $str);
	$str = preg_replace('#ù|ú|û|ü#', 'u', $str);
	$str = preg_replace('#Ù|Ú|Û|Ü|Ŭ#', 'U', $str);
	$str = preg_replace('#ý|ÿ#', 'y', $str);
	$str = preg_replace('#Ý#', 'Y', $str);
	$str = preg_replace('#œ|Œ#', 'oe', $str);
	$str = preg_replace('#æ|Æ#', 'ae', $str);
	return ($str);
}

/*
 * Cette fonctions, adaptée aux prénoms, retire tous les accents, les cédilles
 * et les doubles caractères sur les majuscules uniquement.
 */
function str_to_noaccent_prenom($str){
	$str = preg_replace('#Ç#', 'c', $str);
	$str = preg_replace('#Á|Ã|Ä|Å#', 'a', $str);
	$str = preg_replace('#Ì|Í#', 'i', $str);
	$str = preg_replace('#Ò|Ó|Ô|Õ#', 'o', $str);
	$str = preg_replace('#Ú|Û|Ŭ#', 'u', $str);
	$str = preg_replace('#Ý#', 'y', $str);
	$str = preg_replace('#œ|Œ#', 'oe', $str);
	$str = preg_replace('#æ|Æ#', 'ae', $str);
	return ($str);
}

/*
 * A présent on affiche tous les messages d'erreur générés.
 */
echo $_SESSION['erreur'];
?>