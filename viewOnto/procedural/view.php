<!DOCTYPE html>
<html>
	<head>
		<title>Ontologie</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<?php
	error_reporting(E_ALL);
	ini_set("display_errors",1);
	require_once '../../connect_sparql.php';
	?>
	<body style="font-family: Helvetica, sans-serif">
		<h1>Ontologie du projet Macron-planning</h1>
		<div class="tree">
			<?php 
			$select = "
			PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
			PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
			PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
					
			SELECT ?s WHERE {
			    GRAPH g: {?s ?p rdfs:Class .}
			}
			";
			$result = $store->query($select);
			$rows = $result['result']['rows'];
			for ($i = 0; $i < sizeof($rows); $i++) {
				if (isset($_GET['entity']) && $rows[$i]['s']==$_GET['entity']) {
					echo '<span class="selected">'.$rows[$i]['s'].'</span><br>';
					$select2 = "
					PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
					PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
					PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
									
					SELECT ?s WHERE {
					    GRAPH g: {?s rdfs:domain ".$_GET['entity']." .}
					}
					";
					$result2 = $store->query($select2);
					$rows2 = $result2['result']['rows'];
					for ($j = 0; $j < sizeof($rows2); $j++) {
						echo '<span>&nbsp;&nbsp;&nbsp;&nbsp;'.$rows2[$j]['s'].'</span><br>';
					}
				} else /*if (isset($_GET['property'])) {
					$select2 = "
					PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
					PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
					PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
					
					SELECT ?s WHERE {
					    GRAPH g: {?s ?p 'rdf:Property' .}
					}
					";
					$result2 = $store->query($select2);
					$rows2 = $result2['result']['rows'];
					//echo '<span>'.$rows2[$i]['s'].'</span><br>';
				} else*/ {
					echo '<span>'.$rows[$i]['s'].'</span><br>';
				}
			}
			?>
		</div>
		<div class="view">
<?php

/*
 * Alors là on regarde tout ce qui concerne une entité
 */
if (isset($_GET['entity'])) {
	echo '<h2>Entit&eacute; : '.$_GET['entity'].'</h2>';
	
	$select = "
	PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
	PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
	
	SELECT ?o WHERE {
	    GRAPH g: {".$_GET['entity']." rdfs:comment ?o .}
	}
	";
	$result = $store->query($select);
	$rows = $result['result']['rows'];
	echo '<cite>'.$rows[0]['o'].'</cite>';
	echo '<br><br>';
	
	echo '<fieldset>
	    		<legend>Propri&eacute;t&eacute;(s)</legend>';
	
	$select = "
	PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
	PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
	
	SELECT ?s WHERE {
	    GRAPH g: {?s rdfs:domain ".$_GET['entity']." .}
	}
	";
	$result = $store->query($select);
	$rows = $result['result']['rows'];
	for ($i = 0; $i < sizeof($rows); $i++) {
		echo '<a href="view.php?property='.$rows[$i]['s'].'">'.$rows[$i]['s'].'</a><br>';
	}
	
	echo '</fieldset>';
}

/*
 * Et là tout ce qui concerne une propriété
 */
if (isset($_GET['property'])) {
	echo '<h2>Propri&eacute;t&eacute; : '.$_GET['property'].'</h2>';
	
	/*$select = "
	PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
	PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
	
	SELECT ?o WHERE {
	    GRAPH g: {".$_GET['property']." rdfs:comment ?o .}
	}
	";
	$result = $store->query($select);
	$rows = $result['result']['rows'];
	echo '<cite>'.$rows[0]['o'].'</cite>';
	echo '<br><br>';*/
	
	$select = "
	PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
	PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
	
	SELECT ?o WHERE {
	    GRAPH g: {".$_GET['property']." rdfs:range ?o .}
	}
	";
	$result = $store->query($select);
	$rows = $result['result']['rows'];
	if (!empty($rows[0]['o'])) {
		if ($rows[0]['o'] != "rdfs:Literal") {
			echo '<cite>Valeur : Instance de <a href="view.php?entity='.$rows[0]['o'].'">'.$rows[0]['o'].'</a></cite>';
			echo '<br><br>';
		} else {
			echo '<cite>Valeur : Instance de <a href="#">'.$rows[0]['o'].'</a></cite>';
			echo '<br><br>';
		}
	}
	
	echo '<fieldset>
	    		<legend>Entit&eacute;(s) associ&eacute;e(s)</legend>';
	
	$select = "
	PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
	PREFIX g: <http://localhost/~mbeacco/macro_planning/ontologie.xml>
	
	SELECT ?o WHERE {
	    GRAPH g: {".$_GET['property']." rdfs:domain ?o .}
	}
	";
	$result = $store->query($select);
	$rows = $result['result']['rows'];
	for ($i = 0; $i < sizeof($rows); $i++) {
		echo '<a href="view.php?entity='.$rows[$i]['o'].'">'.$rows[$i]['o'].'</a><br>';
	}
	
	echo '</fieldset>';
}
?>
		</div>
	
		<a href="index.php" class="retour">Retour au menu</a>
	</body>
</html>