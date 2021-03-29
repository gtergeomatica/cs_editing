<?php

session_start();

include '../conn.php';

$table= $_GET["t"];
$schema= $_GET["s"];





//echo $schema;
//echo "<br>";
//echo $table;

$i=1;
echo "<br>";

$query = "UPDATE ".$schema.".".$table." SET";

foreach ($_POST as $param_name => $param_val) {
	if ($param_name !='id') {
		if ($i > 1){
			$query = $query.",";
		}
	if ($param_val !=''){
		$query = $query." " .$param_name. " = '" .$param_val. "'";
	} else  {
	   	$query = $query." " .$param_name. " = NULL";

	}
   	$i=$i+1;
   }
}
if ($table=='r_pubblicita'){
	$query = $query." WHERE id_pubblicita=".$_GET["id"].";";
} else if ($table=='r_segnalefisico') {
	$query = $query." WHERE id_segnale_fisico=".$_GET["id"].";";
} else {
	echo "Tabella non supportata consultare gli amministratori di sistema";
	exit;
}
echo $query;


$result = pg_query($conn, $query);

//exit;

// redirect verso pagina interna
header("location: ../eventop_r_u.php?s=".$schema."&t=".$table."&id1=".$_GET['id']."");


?>