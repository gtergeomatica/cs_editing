<?php 

session_start();

require('./conn.php');

/*Dati una progressiva e un codice strada 
  il servizio get_coordinate restituisce le coordinate geografiche e il codice strada*/ 

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	$query = 'select initcap(nome) as comune,
		st_asgeojson(geom) as geom,
		st_asgeojson(st_envelope(geom)) as bbox
		from (select nome, st_transform(geom, 4326) as geom 
			from geometrie.limiti_comunali
			-- limit 5
		) as comuni;';
	$result = pg_query($conn, $query);
	$nrows = pg_num_rows($result);
	# echo $nrows . " row(s) returned.\n";
	$rows = array();
	while($obj = pg_fetch_assoc($result)) {
		# echo json_encode($obj);
		$rows[] = [
			"comune" => $obj["comune"],
			"bbox" => json_decode($obj["bbox"]),
			"geom" => json_decode($obj["geom"])
		];
	}
	header('Content-Type: application/json');
	if (!empty($nrows)){
		print json_encode($rows);
		# print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo '[{"NOTE":"No data"}]';
	}
	pg_close($conn);

}

?>
