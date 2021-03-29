<?php
session_start();
include '../conn.php';


$schema= pg_escape_string($_GET["s"]);
$tabella=pg_escape_string($_GET["t"]);
//echo $getfiltri;


if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$query="SELECT * From $1.$2;";
    
   //echo $query;
	$result = pg_prepare($conn, "myquery", $query);
    $result = pg_prepare($conn, "myquery", array($schema, $tabella));
	#echo $query;
	#exit;
	$rows = array();
	while($r = pg_fetch_assoc($result)) {
    		$rows[] = $r;
	}
	pg_close($conn);
	#echo $rows ;
	if (empty($rows)==FALSE){
		//print $rows;
		print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo "[{\"NOTE\":'No data'}]";
	}
}

?>


