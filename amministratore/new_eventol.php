<?php

session_start();

include '../conn.php';

$table= $_GET["t"];
$schema= $_GET["s"];

if ($_POST["prog_ini"] < $_POST["prog_fin"]){
	$prog_ini=$_POST["prog_ini"];
	$prog_fin=$_POST["prog_fin"];
} else {
	$prog_ini=$_POST["prog_fin"];
	$prog_fin=$_POST["prog_ini"];
}


$query0= 'SELECT ST_Force2D(ST_LineSubString(geom, (('.$prog_ini.'-prog_ini)/(prog_fin-prog_ini)), (('.$prog_fin.'-prog_ini)/(prog_fin-prog_ini)))) as geom FROM geometrie.elementi_stradali WHERE cod_strada =\''.$_POST["cod_strada"].'\' and  prog_ini < '.$_POST["prog_ini"].' and prog_fin >'.$_POST["prog_ini"].';';

echo $query0;

echo "<br>";


$result0 = pg_query($conn, $query0);
while($r0 = pg_fetch_assoc($result0)) {
	//$percentuale= $_POST["prog_ini"]/$r0["prog_fin"];
	//echo $percentuale;
	$geometria = $r0["geom"];
	echo $geometria;
}
echo "<br>";
//echo $query0;



//exit;
//echo $schema;
//echo "<br>";
//echo $table;

$i=1;
echo "<br>";

$query = "INSERT INTO ".$schema.".".$table." ";
$query = $query." ( ";

foreach ($_POST as $param_name => $param_val) {
	if ($param_name !='id' and  $param_val !='') {
		if ($i > 1){
			$query = $query.",";
		}
   	$query = $query." " .$param_name. " ";
   	$i=$i+1;
   }
}

$query = $query." , geom) VALUES ( ";

$i=1;
foreach ($_POST as $param_name => $param_val) {
	if ($param_name !='id' and $param_val !='') {
		if ($i > 1){
			$query = $query.",";
		}
   	if(is_numeric($param_val)){
   		$query = $query." " .$param_val. " ";
   	} else {
   		$query = $query." '" .$param_val. "' ";
   	}
   	$i=$i+1;
   }
}

$query = $query.", '".$geometria."');";


//$query = $query." WHERE id=".$_POST["id"].";";

echo $query;


$result = pg_query($conn, $query);


//exit;

// redirect verso pagina interna
header("location: ../eventol.php?login=".$_POST["login"]."&s=".$schema."&t=".$table."");


?>