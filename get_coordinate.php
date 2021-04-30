<?php 

session_start();

require('./conn.php');

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$cod_strada = pg_escape_string($_GET["cod_strada"]);
	$prog = pg_escape_string($_GET["prog"]);
	if ($cod_strada =='' OR $prog =='') {
		die('[{"ERROR":"Il WS richiede come input sia il codice strada che la progressiva"}]');
	} else {
		$query= 'SELECT st_x(st_transform(geom,4326)) as lon , st_y(st_transform(geom,4326)) as lat FROM
		(SELECT ST_Force3D(ST_LineInterpolatePoint(ST_LineMerge(e.geom),
		(('.$prog.'-e.prog_ini)/(e.prog_fin-e.prog_ini)*st_length(e.geom))
		/st_length(e.geom))) as geom 
		FROM geometrie.elementi_stradali e 
		WHERE e.cod_strada = \''.$cod_strada.'\'
		and  e.prog_ini < '.$prog.' 
		and e.prog_fin > '.$prog.') as foo;';
		$result = pg_query($conn, $query);
		//echo $query;
		#exit;
		$rows = array();
		while($r = pg_fetch_assoc($result)) {
				$rows[] = $r;
				//echo $r['progressiva'];
		}
		//pg_close($conn);
		#echo $rows ;
		if (empty($rows)==FALSE){
			//print $rows;
			print json_encode(array_values(pg_fetch_all($result)));
		} else {
			echo '[{"NOTE":"No data"}]';
		}
		pg_close($conn);



	}
}

?>