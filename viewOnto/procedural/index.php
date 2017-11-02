<?php
require_once '../../connect_sparql.php';

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
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ontologie</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>Ontologie du projet Macron-planning</h1>
		<div class="tree">
			<?php 
			for ($i = 0; $i < sizeof($rows); $i++) {
				echo '<span>'.$rows[$i]['s'].'</span><br>';
			}
			?>
		</div>
		<div class="view">
			<table>
			<?php 
			for ($i = 0; $i < sizeof($rows); $i++) {
				echo '<tr><td><a href="view.php?entity='.$rows[$i]['s'].'">'.$rows[$i]['s'].'</a></td></tr>';
			}
			?>
			</table>
		</div>
	</body>
	
</html>