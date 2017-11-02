<html>
<head>
<meta charset="UTF-8">
<style>
body {
	margin: 0px;
	padding: 0px;
}

#canvas1 {
	background-color: orange;
}
</style>
</head>
<body>
<?php
$effort = $_GET['effort'];
$nbDeveloppeurs = $_GET['nbDevs'];
$developpeurs = array("Maxime", "Christophe", "Arnaud", "Florent");
$competenceRequise = array("PHP", "HTML", "CSS", "SQL", "JAVA");
$coefEtatEspritRessource = array(0.90, 0.80, 0.65, 0.70);
$efficacitéCompRessource;
$efficacitéMoyRessource = array(0.4, 0.5, 0.90, 0.97);
$efficacitéMoyGlobale = 0;
$efficacitéMoyCompGlobale = 0;
$efficacitéCompGlobale[5];
$coefEtatEspritGlobal = 0;
$duree = 0; // resultat du calcul

$efficacitéCompRessource[0][0] = 0.8;
$efficacitéCompRessource[0][1] = 0.7;
$efficacitéCompRessource[0][2] = 0.4;
$efficacitéCompRessource[0][3] = 0.8;
$efficacitéCompRessource[0][4] = 0.65;

$efficacitéCompRessource[1][0] = 0.4;
$efficacitéCompRessource[1][1] = 0.8;
$efficacitéCompRessource[1][2] = 0.9;
$efficacitéCompRessource[1][3] = 0.3;
$efficacitéCompRessource[1][4] = 0.6;

$efficacitéCompRessource[2][0] = 0.95;
$efficacitéCompRessource[2][1] = 0.85;
$efficacitéCompRessource[2][2] = 0.80;
$efficacitéCompRessource[2][3] = 0.95;
$efficacitéCompRessource[2][4] = 0.75;

$efficacitéCompRessource[3][0] = 0.90;
$efficacitéCompRessource[3][1] = 0.85;
$efficacitéCompRessource[3][2] = 0.70;
$efficacitéCompRessource[3][3] = 0.85;
$efficacitéCompRessource[3][4] = 0.65;

/*echo '<PRE>';
print_r($efficacitéCompRessource);
print_r($efficacitéMoyRessource);
print_r($competenceRequise);
echo '</PRE';*/
//echo "effort : ".$effort." jours\n";
//echo "\n<hr>\n";



//Durée approx en fonction de l'efficacité moyenne des ressources uniquement
/*echo "A valider\n";
$efficacitéMoyGlobale = 0;
for ($i=0; $i < $nbDeveloppeurs; $i++) {
	$j = $i + 1;
	echo "eff.moy.res.".$j." : ".$efficacitéMoyRessource[$i]."\n";
	$efficacitéMoyGlobale = $efficacitéMoyGlobale + $efficacitéMoyRessource[$i];
}

//$efficacitéMoyGlobale = $efficacitéMoyGlobale / $nbDeveloppeurs;
echo "eff.moy.glo : ".$efficacitéMoyGlobale."\n";

$duree = $effort / $efficacitéMoyGlobale;
echo "Durée (eff.moy) : ".ceil($duree)." jours\n\n<hr>\n";



//Durée approx en fonction des compétences uniquement
echo "A valider\n";
$efficacitéMoyGlobale = 0;
for ($noCompetence = 0; $noCompetence < sizeof($competenceRequise); $noCompetence++) {
	echo $competenceRequise[$noCompetence]."\n";
	echo "eff.comp.res.1 : ".$efficacitéCompRessource[0][$noCompetence]."\n";
	echo "eff.comp.res.2 : ".$efficacitéCompRessource[1][$noCompetence]."\n";
	for ($noRessource = 0; $noRessource < $nbDeveloppeurs; $noRessource++) {
		$efficacitéCompGlobale[$noCompetence] += $efficacitéCompRessource[$noRessource][$noCompetence];
	}
	echo "eff.comp.res.1 + eff.comp.res.2 : ".$efficacitéCompGlobale[$noCompetence]."\n";
	
	$efficacitéCompGlobale[$noCompetence] = $efficacitéCompGlobale[$noCompetence] / $nbDeveloppeurs;
	echo "eff.comp.glo/nbDev : ".ceil($efficacitéCompGlobale[$noCompetence])."\n";
	
	$efficacitéMoyGlobale = $efficacitéMoyGlobale + $efficacitéCompGlobale[$noCompetence];
	echo "eff.moy.glo : ".ceil($efficacitéMoyGlobale)."\n\n";
}

$efficacitéMoyGlobale = $efficacitéMoyGlobale / (sizeof($competenceRequise) / $nbDeveloppeurs);
echo "eff.moy.glo / nbDev : ".$efficacitéMoyGlobale."\n";

$duree = $effort / $efficacitéMoyGlobale;
echo "Durée (comp.res) : ".ceil($duree)." jours\n\n<hr>\n";



//Durée approx en fonction de l'état d'esprit de la ressource sur le projet uniquement
echo "A valider\n";
for ($i=0; $i < $nbDeveloppeurs; $i++) {
	$coefEtatEspritGlobal = $coefEtatEspritGlobal + $coefEtatEspritRessource[$i];
	echo "coef.ee.glo : ".$coefEtatEspritGlobal."\n";
	echo "coef.ee.res : ".$coefEtatEspritRessource[$i]."\n";
}
$coefEtatEspritGlobal = ($coefEtatEspritGlobal + 1) / $nbDeveloppeurs;
echo "(coef.ee.glo +1) / nbDev : ".ceil($coefEtatEspritGlobal)."\n";

$duree = $effort / $coefEtatEspritGlobal;
echo "Durée (ee.res) : ".ceil($duree)." jours\n\n<hr>\n";

*/




function etatEsprit($numDev, $nbDeveloppeurs, $coefEtatEspritRessource, $effort, $developpeurs) {
	$min = $effort;
	for ($j = 0; $j < sizeof($developpeurs); $j++) {
		//echo "coef.ee.res.connu.".$developpeurs[$numDev]." : ".$coefEtatEspritRessource[$numDev]."\n";
		if ($j == $numDev) {
			$coefEtatEspritGlobal = $coefEtatEspritRessource[$numDev];
			//echo "coef.ee.glo : ".$coefEtatEspritGlobal."\n";
		} else {
			$coefEtatEspritGlobal = $coefEtatEspritRessource[$numDev] + $coefEtatEspritRessource[$j];
			//echo "coef.ee.res.".$developpeurs[$j]." : ".$coefEtatEspritRessource[$j]."\n";
			//echo "coef.ee.glo : ".$coefEtatEspritGlobal."\n";
		}
		$coefEtatEspritGlobal = ($coefEtatEspritGlobal / $nbDeveloppeurs);
		//echo "(coef.ee.glo / nbDev) +1 : ".ceil($coefEtatEspritGlobal)."\n";
		$duree = $effort / ($coefEtatEspritGlobal + 1);
		//echo "Durée (ee.res) : ".ceil($duree)." jours\n\n<hr>\n";
		if ($min > $duree) {
			$min = $duree;
			$devMin2 = $j;
			$devMin1 = $numDev;
		}
	}
	//echo "<hr><hr>\n";
	return array($devMin1, $devMin2, $min);
}

function effMoyenne($numDev, $nbDeveloppeurs, $developpeurs, $efficacitéMoyRessource, $effort) {
	$efficacitéMoyGlobale = 0;
	$min = $effort;
	
	if ($nbDeveloppeurs == 4) {
		$efficacitéMoyGlobale = $efficacitéMoyRessource[0] + $efficacitéMoyRessource[1] + $efficacitéMoyRessource[2] + $efficacitéMoyRessource[3];
		
		$efficacitéMoyGlobale = $efficacitéMoyGlobale / $nbDeveloppeurs;
		//echo "eff.moy.glo : ".$efficacitéMoyGlobale."\n";
		
		$duree = $effort / ($efficacitéMoyGlobale + 1);
		//echo "Durée (eff.moy) : ".ceil($duree)." jours\n\n<hr>\n";
		
		if ($min > $duree) {
			$min = $duree;
		}
	
		//echo "<hr><hr>\n";
		return array(0, 1, $min, 2, 3);
		
	} else {
	
		for ($i=0; $i < sizeof($developpeurs); $i++) {
			//echo "eff.moy.res.connu.".$developpeurs[$numDev]." : ".$efficacitéMoyRessource[$numDev]."\n";
			if ($i == $numDev) {
				$efficacitéMoyGlobale = $efficacitéMoyRessource[$numDev];
			} else {
				//echo "eff.moy.res.".$developpeurs[$i]." : ".$efficacitéMoyRessource[$i]."\n";
				$efficacitéMoyGlobale = $efficacitéMoyRessource[$numDev] + $efficacitéMoyRessource[$i];
			}
			
			$efficacitéMoyGlobale = $efficacitéMoyGlobale / $nbDeveloppeurs;
			//echo "eff.moy.glo : ".$efficacitéMoyGlobale."\n";
			
			$duree = $effort / ($efficacitéMoyGlobale + 1);
			//echo "Durée (eff.moy) : ".ceil($duree)." jours\n\n<hr>\n";
			
			if ($min > $duree) {
				$min = $duree;
				$devMin2 = $i;
				$devMin1 = $numDev;
			}
		}
		
		//echo "<hr><hr>\n";
		return array($devMin1, $devMin2, $min);
	}
	
}

function effCompMoyenne($numDev, $nbDeveloppeurs, $developpeurs, $competenceRequise, $efficacitéCompRessource, $effort) {
	$min = $effort;
	
	if ($nbDeveloppeurs == 4) {
		for ($noCompetence = 0; $noCompetence < sizeof($competenceRequise); $noCompetence++) {
			//echo $competenceRequise[$noCompetence]."\n";
			//echo "eff.comp.res.".$developpeurs[$noRessource]." : ".$efficacitéCompRessource[$noRessource][$noCompetence]."\n";
			$efficacitéCompGlobale[$noCompetence] = $efficacitéCompRessource[0][$noCompetence] + $efficacitéCompRessource[1][$noCompetence];
			$efficacitéCompGlobale[$noCompetence] += $efficacitéCompRessource[2][$noCompetence];
			$efficacitéCompGlobale[$noCompetence] += $efficacitéCompRessource[3][$noCompetence];
			
			//echo "eff.comp.glo : ".$efficacitéCompGlobale[$noCompetence]."\n";
			
			$efficacitéCompGlobale[$noCompetence] = ($efficacitéCompGlobale[$noCompetence] + 1) / $nbDeveloppeurs;
			//echo "eff.comp.glo/nbDev : ".ceil($efficacitéCompGlobale[$noCompetence])."\n";
			
			$efficacitéMoyCompGlobale = $efficacitéMoyCompGlobale + $efficacitéCompGlobale[$noCompetence];
			//echo "eff.moy.glo : ".ceil($efficacitéMoyCompGlobale)."\n\n";
		}
		
		$efficacitéMoyCompGlobale = $efficacitéMoyCompGlobale / (sizeof($competenceRequise));
		//echo "eff.moy.glo / nbDev : ".$efficacitéMoyCompGlobale."\n";
		
		$duree = $effort / ($efficacitéMoyCompGlobale);
		//echo "Durée (comp.res) : ".ceil($duree)." jours\n\n<hr>\n";
		
		if ($min > $duree) {
			$min = $duree;
		}
		
		return array(0, 1, $min, 2, 3);
		
	} else {
	
		for ($noRessource = 0; $noRessource < sizeof($developpeurs); $noRessource++) {
			for ($noCompetence = 0; $noCompetence < sizeof($competenceRequise); $noCompetence++) {
				//echo $competenceRequise[$noCompetence]."\n";
				//echo "eff.moy.res.connu.".$developpeurs[$numDev]." : ".$efficacitéCompRessource[$numDev][$noCompetence]."\n";
				if ($noRessource == $numDev) {
					$efficacitéCompGlobale[$noCompetence] = $efficacitéCompRessource[$numDev][$noCompetence];
				} else {
					//echo "eff.comp.res.".$developpeurs[$noRessource]." : ".$efficacitéCompRessource[$noRessource][$noCompetence]."\n";
					$efficacitéCompGlobale[$noCompetence] = $efficacitéCompRessource[$noRessource][$noCompetence] + $efficacitéCompRessource[$numDev][$noCompetence];
				}
				//echo "eff.comp.glo : ".$efficacitéCompGlobale[$noCompetence]."\n";
				
				$efficacitéCompGlobale[$noCompetence] = ($efficacitéCompGlobale[$noCompetence] + 1) / $nbDeveloppeurs;
				//echo "eff.comp.glo/nbDev : ".ceil($efficacitéCompGlobale[$noCompetence])."\n";
				
				$efficacitéMoyCompGlobale = $efficacitéMoyCompGlobale + $efficacitéCompGlobale[$noCompetence];
				//echo "eff.moy.glo : ".ceil($efficacitéMoyCompGlobale)."\n\n";
			}
			
			$efficacitéMoyCompGlobale = $efficacitéMoyCompGlobale / (sizeof($competenceRequise));
			//echo "eff.moy.glo / nbDev : ".$efficacitéMoyCompGlobale."\n";
			
			$duree = $effort / ($efficacitéMoyCompGlobale);
			//echo "Durée (comp.res) : ".ceil($duree)." jours\n\n<hr>\n";
			
			if ($min > $duree) {
				$min = $duree;
				$devMin2 = $noRessource;
				$devMin1 = $numDev;
			}
		}
		
		//echo "<hr><hr>\n";
		return array($devMin1, $devMin2, $min);
	}
	
}










/*// Not yet implemented


//Durée approx en fonction de tout ça
//moyenne des ressources
$efficacitéMoyGlobale = 1;
for ($i=0; $i < $nbDeveloppeurs; $i++) {
	$efficacitéMoyGlobale += $efficacitéMoyRessource[$i];
}

$efficacitéMoyGlobale = $efficacitéMoyGlobale / $nbDeveloppeurs;

//moyenne des compétences
$efficacitéMoyCompGlobale = 0;
for ($noCompetence = 0; $noCompetence < sizeof($competenceRequise); $noCompetence++) {
	echo $competenceRequise[$noCompetence]."\n";
	echo "eff.comp.res.1 : ".$efficacitéCompRessource[0][$noCompetence]."\n";
	echo "eff.comp.res.2 : ".$efficacitéCompRessource[1][$noCompetence]."\n";
	for ($noRessource = 0; $noRessource < $nbDeveloppeurs; $noRessource++) {
		$efficacitéCompGlobale[$noCompetence] += $efficacitéCompRessource[$noRessource][$noCompetence];
	}
	echo "eff.comp.res.1 + eff.comp.res.2 : ".$efficacitéCompGlobale[$noCompetence]."\n";
	
	$efficacitéCompGlobale[$noCompetence] = $efficacitéCompGlobale[$noCompetence] / $nbDeveloppeurs;
	echo "eff.comp.glo/nbDev : ".ceil($efficacitéCompGlobale[$noCompetence])."\n";
	
	$efficacitéMoyCompGlobale = $efficacitéMoyCompGlobale + $efficacitéCompGlobale[$noCompetence];
	echo "eff.moy.glo : ".ceil($efficacitéMoyCompGlobale)."\n\n";
}

$efficacitéMoyCompGlobale = $efficacitéMoyCompGlobale / (sizeof($competenceRequise) / $nbDeveloppeurs);
echo "eff.moy.glo / nbDev : ".$efficacitéMoyCompGlobale."\n";


//coefficient d'état d'esprit
for ($i=0; $i < $nbDeveloppeurs; $i++) {
	$coefEtatEspritGlobal = $coefEtatEspritGlobal + $coefEtatEspritRessource[$i];
	echo "coef.ee.glo : ".$coefEtatEspritGlobal."\n";
	echo "coef.ee.res : ".$coefEtatEspritRessource[$i]."\n";
}
$coefEtatEspritGlobal = ($coefEtatEspritGlobal / $nbDeveloppeurs);
echo "(coef.ee.glo / nbDev) +1 : ".ceil($coefEtatEspritGlobal)."\n";


$duree = ($effort / $efficacitéMoyCompGlobale) * $coefEtatEspritGlobal;
echo "Durée (tout ensemble) : ".ceil($duree)."\n\n<hr>\n";
/**/











//Suggestion des pairs
function suggestPair($nbDeveloppeurs, $developpeurs, $coefEtatEspritRessource, $effort, $efficacitéMoyRessource, $competenceRequise, $efficacitéCompRessource) {
	
	$dureeMin = $effort;
	$methodeMin = "";
	
	//echo "efficacité moyenne par compétence\n";
	for ($i = 0; $i < sizeof($developpeurs); $i++) {
		$devsMin = effCompMoyenne($i, $nbDeveloppeurs, $developpeurs, $competenceRequise, $efficacitéCompRessource, $effort);
		//echo $developpeurs[$devsMin[0]]." et ".$developpeurs[$devsMin[1]]." en ".round($devsMin[2], 2)." jours.<hr>\n\n";
		if ($dureeMin > ceil($devsMin[2])) {
			$methodeMin = "efficacité moyenne par compétence";
			$dureeMin = ceil($devsMin[2]);
			$pair[0] = $devsMin[0];
			$pair[1] = $devsMin[1];
			if ($nbDeveloppeurs == 4) {
				$pair[2] = 2;
				$pair[3] = 3;
			} else {
				$pair[2] = -1;
				$pair[3] = -1;
			}
		}
	}
	//echo "Paire la plus efficace pour ce développement avec la méthode ".$methodeMin." :\n";
	//echo $developpeurs[$pair[0]]." et ".$developpeurs[$pair[1]]." en ".$dureeMin." jours.<hr>\n\n";
	
	//echo "état d'esprit sur le projet\n";
	for ($i = 0; $i < sizeof($developpeurs); $i++) {
		$devsMin = etatEsprit($i, $nbDeveloppeurs, $coefEtatEspritRessource, $effort, $developpeurs);
		//echo $developpeurs[$devsMin[0]]." et ".$developpeurs[$devsMin[1]]." en ".ceil($devsMin[2])." jours.<hr>\n\n";
		if ($dureeMin > ceil($devsMin[2])) {
			$methodeMin = "état d'esprit sur le projet";
			$dureeMin = ceil($devsMin[2]);
			$pair[0] = $devsMin[0];
			$pair[1] = $devsMin[1];
			if ($nbDeveloppeurs == 4) {
				$pair[2] = 2;
				$pair[3] = 3;
			} else {
				$pair[2] = -1;
				$pair[3] = -1;
			}
		}
	}
	//echo "Paire la plus efficace pour ce développement avec la méthode ".$methodeMin." :\n";
	//echo $developpeurs[$pair[0]]." et ".$developpeurs[$pair[1]]." en ".$dureeMin." jours.<hr>\n";
	
	//echo "efficacité moyenne\n";
	for ($i = 0; $i < sizeof($developpeurs); $i++) {
		$devsMin = effMoyenne($i, $nbDeveloppeurs, $developpeurs, $efficacitéMoyRessource, $effort);
		//echo $developpeurs[$devsMin[0]]." et ".$developpeurs[$devsMin[1]]." en ".ceil($devsMin[2])." jours.<hr>\n\n";
		if ($dureeMin > ceil($devsMin[2])) {
			$methodeMin = "efficacité moyenne";
			$dureeMin = ceil($devsMin[2]);
			$pair[0] = $devsMin[0];
			$pair[1] = $devsMin[1];
			if ($nbDeveloppeurs == 4) {
				$pair[2] = 2;
				$pair[3] = 3;
			} else {
				$pair[2] = -1;
				$pair[3] = -1;
				
			}
		}
	}
	//echo "Paire la plus efficace pour ce développement avec la méthode ".$methodeMin." :\n";
	//echo $developpeurs[$pair[0]]." et ".$developpeurs[$pair[1]]." en ".$dureeMin." jours.<hr>\n";
	
	echo "Paire la plus efficace pour ce développement :\n";
	if ($nbDeveloppeurs == 4) {
		echo "Tout le monde en ".$dureeMin." jours avec leur ".$methodeMin;
	} else {
		echo $developpeurs[$pair[0]]." et ".$developpeurs[$pair[1]]." en ".$dureeMin." jours. C'est la paire la plus efficace grâce à leur ".$methodeMin;
	}
	$retour = array($dureeMin, $pair[0], $pair[1], $pair[2], $pair[3]);
	
	return $retour;
}






//echo "\n<hr>\n";
$return = suggestPair($nbDeveloppeurs, $developpeurs, $coefEtatEspritRessource, $effort, $efficacitéMoyRessource, $competenceRequise, $efficacitéCompRessource);

/*while (1) {
	fopen("test.txt", 'w');
}*/


?>
		<form method="get">
			<input type="number" name="effort" min="1" max="90" placeholder="effort" value="<?php echo $_GET['effort']?>">
			<input type="number" name="nbDevs" max="4" min="2" placeholder="nbDevs" value="<?php echo $_GET['nbDevs']?>">
			<input type="submit" value="Calculer">
		</form>
		<canvas id='canvas1' width='1280' height='720'></canvas>

		<script>
			//On dessine ici le diagramme de Gantt en fonction des résultats du dessus
			var canvas = document.getElementById('canvas1');
			var ctx = canvas.getContext('2d');
			
			ctx.font = "32pt Helvetica, sans-serif";
			ctx.textBaseline = "top";
			
			ctx.textAlign = "center";
			ctx.fillText("Macro Planning", 1280/2, 0);

			ctx.font = "14pt Helvetica, sans-serif";
			ctx.textAlign = "left";
			ctx.fillText("Maxime", 10, 80);
			ctx.fillText("Christophe", 10, 150);
			ctx.fillText("Arnaud", 10, 220);
			ctx.fillText("Florent", 10, 290);

			ctx.strokeRect(125, 60, 1100, 270);

			ctx.font = "12pt Helvetica, sans-serif";
			ctx.textAlign = "right";
			ctx.fillRect(130, 350, 1100, 5);
			ctx.fillRect(130, 345, 5, 15);
			
			ctx.fillRect(150, 345, 2, 15);
			ctx.fillRect(170, 345, 2, 15);
			ctx.fillRect(190, 345, 2, 15);
			ctx.fillRect(210, 345, 2, 15);
			ctx.fillText("Semaine 1", 230, 365);
			ctx.fillRect(230, 345, 5, 15);
			
			ctx.fillRect(250, 345, 2, 15);
			ctx.fillRect(270, 345, 2, 15);
			ctx.fillRect(290, 345, 2, 15);
			ctx.fillRect(310, 345, 2, 15);
			ctx.fillText("Semaine 2", 330, 365);
			ctx.fillRect(330, 345, 5, 15);

			ctx.fillRect(350, 345, 2, 15);
			ctx.fillRect(370, 345, 2, 15);
			ctx.fillRect(390, 345, 2, 15);
			ctx.fillRect(410, 345, 2, 15);
			ctx.fillText("Semaine 3", 430, 365);
			ctx.fillRect(430, 345, 5, 15);

			ctx.fillRect(450, 345, 2, 15);
			ctx.fillRect(470, 345, 2, 15);
			ctx.fillRect(490, 345, 2, 15);
			ctx.fillRect(510, 345, 2, 15);
			ctx.fillText("Semaine 4", 530, 365);
			ctx.fillRect(530, 345, 5, 15);

			ctx.fillRect(550, 345, 2, 15);
			ctx.fillRect(570, 345, 2, 15);
			ctx.fillRect(590, 345, 2, 15);
			ctx.fillRect(610, 345, 2, 15);
			ctx.fillText("Semaine 5", 630, 365);
			ctx.fillRect(630, 345, 5, 15);

			ctx.fillRect(650, 345, 2, 15);
			ctx.fillRect(670, 345, 2, 15);
			ctx.fillRect(690, 345, 2, 15);
			ctx.fillRect(710, 345, 2, 15);
			ctx.fillText("Semaine 6", 730, 365);
			ctx.fillRect(730, 345, 5, 15);

			ctx.fillRect(750, 345, 2, 15);
			ctx.fillRect(770, 345, 2, 15);
			ctx.fillRect(790, 345, 2, 15);
			ctx.fillRect(810, 345, 2, 15);
			ctx.fillText("Semaine 7", 830, 365);
			ctx.fillRect(830, 345, 5, 15);

			ctx.fillRect(850, 345, 2, 15);
			ctx.fillRect(870, 345, 2, 15);
			ctx.fillRect(890, 345, 2, 15);
			ctx.fillRect(910, 345, 2, 15);
			ctx.fillText("Semaine 8", 930, 365);
			ctx.fillRect(930, 345, 5, 15);

			ctx.fillRect(950, 345, 2, 15);
			ctx.fillRect(970, 345, 2, 15);
			ctx.fillRect(990, 345, 2, 15);
			ctx.fillRect(1010, 345, 2, 15);
			ctx.fillText("Semaine 9", 1030, 365);
			ctx.fillRect(1030, 345, 5, 15);

			ctx.fillRect(1050, 345, 2, 15);
			ctx.fillRect(1070, 345, 2, 15);
			ctx.fillRect(1090, 345, 2, 15);
			ctx.fillRect(1110, 345, 2, 15);
			ctx.fillText("Semaine 10", 1130, 365);
			ctx.fillRect(1130, 345, 5, 15);
			
			ctx.fillRect(1150, 345, 2, 15);
			ctx.fillRect(1170, 345, 2, 15);
			ctx.fillRect(1190, 345, 2, 15);
			ctx.fillRect(1210, 345, 2, 15);
			ctx.fillText("Semaine 11", 1230, 365);
			ctx.fillRect(1230, 345, 5, 15);
			
			ctx.fillStyle = '#0AA';
			<?php 
			switch ($return[1]) {
				case 0:
					echo 'ctx.fillRect(130, 65, '.$return[0].'*20, 50);';
					break;
				
				case 1:
					echo 'ctx.fillRect(130, 135, '.$return[0].'*20, 50);';
					break;
				
				case 2:
					echo 'ctx.fillRect(130, 205, '.$return[0].'*20, 50);';
					break;
				
				case 3:
					echo 'ctx.fillRect(130, 275, '.$return[0].'*20, 50);';
					break;
			}
			switch ($return[2]) {
				case 0:
					echo 'ctx.fillRect(130, 65, '.$return[0].'*20, 50);';
					break;
			
				case 1:
					echo 'ctx.fillRect(130, 135, '.$return[0].'*20, 50);';
					break;
			
				case 2:
					echo 'ctx.fillRect(130, 205, '.$return[0].'*20, 50);';
					break;
			
				case 3:
					echo 'ctx.fillRect(130, 275, '.$return[0].'*20, 50);';
					break;
			}
			switch ($return[3]) {
				case 0:
					echo 'ctx.fillRect(130, 65, '.$return[0].'*20, 50);';
					break;
						
				case 1:
					echo 'ctx.fillRect(130, 135, '.$return[0].'*20, 50);';
					break;
						
				case 2:
					echo 'ctx.fillRect(130, 205, '.$return[0].'*20, 50);';
					break;
						
				case 3:
					echo 'ctx.fillRect(130, 275, '.$return[0].'*20, 50);';
					break;
			}
			switch ($return[4]) {
				case 0:
					echo 'ctx.fillRect(130, 65, '.$return[0].'*20, 50);';
					break;
						
				case 1:
					echo 'ctx.fillRect(130, 135, '.$return[0].'*20, 50);';
					break;
						
				case 2:
					echo 'ctx.fillRect(130, 205, '.$return[0].'*20, 50);';
					break;
						
				case 3:
					echo 'ctx.fillRect(130, 275, '.$return[0].'*20, 50);';
					break;
			}
			?>
			//ctx.fillRect(130, 65, <?php echo $return[0]; ?>*20, 50);
			//ctx.fillRect(130, 135, <?php echo $return[0]; ?>*20, 50);
			//ctx.fillRect(130, 205, <?php echo $return[0]; ?>*20, 50);
			//ctx.fillRect(130, 275, 10*20, 50);
        </script>
	</body>
</html>