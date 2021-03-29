<?php

session_start();

include '../conn.php';

$table= $_GET["t"];
$schema= $_GET["s"];

if ($table=='t%'){

	$query0= 'SELECT ST_Force2D(ST_LineInterpolatePoint(geom, (('.$_POST["prog_ini"].'-prog_ini)/(prog_fin-prog_ini)*st_length(geom))/st_length(geom))) as geom FROM geometrie.elementi_stradali WHERE cod_strada =\''.$_POST["cod_strada"].'\' and  prog_ini < '.$_POST["prog_ini"].' and prog_fin >'.$_POST["prog_ini"].';';

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
}
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


// geometria solo se tabella t_
if ($table=='t%'){
	$query = $query." , geom) VALUES ( ";
} else {
	$query = $query." ) VALUES ( ";
}


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
// geometria solo se tabella t_
if ($table=='t%'){
	$query = $query.", '".$geometria."');";
} else {
	$query = $query.");";
}

//$query = $query." WHERE id=".$_POST["id"].";";

echo $query;


//exit;

$result = pg_query($conn, $query);


//exit;

// redirect verso pagina interna
if ($table=='t%'){
	header("location: ../eventop.php?login=".$_POST["login"]."&s=".$schema."&t=".$table."");
} else {
	echo "<br>";
	echo "<br><h2>Elemento inserito con successo, è possibile chiudere la scheda e tornare alla mappa.</h2>";
}

?>