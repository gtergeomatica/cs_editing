<?php 

session_start();

require('./conn.php');

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$tabella= $_GET["t"];
	$campo= $_GET["c"];
	$campo_ok=str_replace('d_','',$campo);
	if ($campo == 'd_lato'){
		$query="SELECT * From normativa.lato;";
	} else {
		$query="SELECT * From normativa.".$tabella."_".$campo_ok.";";
    }
    //echo $query;
	$result = pg_query($conn, $query);
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



