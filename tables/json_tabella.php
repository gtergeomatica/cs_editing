<?php
session_start();
include '../conn.php';


$schema= pg_escape_string($_GET["s"]);
$tabella=pg_escape_string($_GET["t"]);
//echo $getfiltri;
//$t=$schema.'.'.$tabella;
//echo $t ."<br>";
if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
    $query="SELECT * FROM $schema.$tabella";
    $result = pg_query($conn, $query);
	
    
    /*$query='SELECT * FROM $1';
    
   //echo $query;
	$result = pg_prepare($conn, "my_query", $query);
    $result = pg_execute($conn, "my_query", array($t));*/
	#echo $query;
	#exit;
	$rows = array();
	while($r = pg_fetch_assoc($result)) {
    		$rows[] = $r;
	}
	#echo $rows ;
	if (empty($rows)==FALSE){
		//print $rows;
		print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo "[{\"NOTE\":'No data'}]";
	}
	pg_close($conn);

}

?>


