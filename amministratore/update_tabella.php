<?php

session_start();

include '../conn.php';

$table=pg_escape_string($_GET["t"]);
$schema=pg_escape_string($_GET["s"]);
$id=pg_escape_string($_GET["id"]);





//echo $schema;
//echo "<br>";
//echo $table;

$i=1;
echo "<br>";

$query = "UPDATE ".$schema.".".$table." SET";

foreach ($_POST as $param_name => $param_val) {
	if ($param_name !='id' OR $param_name !='d_fase_proc' ) {
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
	$query = $query." WHERE id_pubblicita=$1;";
} else if ($table=='r_segnalefisico') {
	$query = $query." WHERE id_segnale_fisico=$1;";
} else if ($table=='r_conpub_proc') {
	$query = $query." WHERE id=$1;";
} else {
	echo "Tabella ".$table." non supportata consultare gli amministratori di sistema";
	exit;
}
//echo $query;


//$result = pg_query($conn, $query);

$result=pg_prepare($conn,"edit", $query);

$result=pg_execute($conn,"edit", array($id));


//exit;

// redirect verso pagina interna
header("location: ../eventop_r_u.php?s=".$schema."&t=".$table."&id1=".$id."");


?>