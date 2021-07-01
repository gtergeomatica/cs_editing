<?php 

session_start();

require('./conn.php');
/*Data una coppia di coordinate geografche (lon, lat)
 il servizio get_progressiva restituisce la progressiva e il codice strada*/ 

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$lat = pg_escape_string($_GET["lat"]);
	$lon = pg_escape_string($_GET["lon"]);
	if ($lat =='' or $lon ==''){
		die('[{"ERROR":"Il WS richiede come parametri sia la latitudine che la longitudine. Verifica di averli correttamente inseriti"}]');
	}
	/*$query="SELECT ST_3DClosestPoint(st_transform(v.geom,4326), ST_GeomFromText('POINT($1,$2))),
    FROM geometrie.elementi_stradali v";*/
    
    /*$query_progressiva= 'SELECT round(v.prog_ini::numeric, 0)+
    round((
    ST_LineLocatePoint(
        ST_LineMerge(ST_SnapToGrid(v.geom,1)),
        ST_ClosestPoint(
            v.geom,
            ST_3DClosestPoint(
                v.geom , 
                st_transform(ST_GeomFromText(\'POINT($1 $2 0)\',4326),32632) 
            )
        )
    )*ST_Length(v.geom))::numeric,0) as progressiva, v.cod_strada 
    FROM geometrie.elementi_stradali v 
    order by ST_Distance( v.geom , st_transform(ST_GeomFromText(\'POINT($3 $4 0)\',4326),32632) )
    limit 1;';*/
               	
    $query_progressiva= "SELECT round(v.prog_ini::numeric, 0)+
    round((
    ST_LineLocatePoint(
        ST_LineMerge(ST_SnapToGrid(v.geom,1)),
        ST_ClosestPoint(
            v.geom,
            ST_3DClosestPoint(
                v.geom , 
                st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) 
            )
        )
    )*ST_Length(v.geom))::numeric,0) as progressiva, v.cod_strada 
    FROM geometrie.elementi_stradali v 
    order by ST_Distance( v.geom , st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) )
    limit 1;";


    
    /*cod_strada=(SELECT v.cod_strada
            FROM geometrie.elementi_stradali v, eventop.t_cippi c 
            WHERE c.id=new.id
            order by ST_Distance(v.geom, c.geom)  limit 1),*/

    //echo $query_progressiva;
    //echo "<br>";
    /*$result=pg_prepare($conn, "myquery", $query_progressiva);
    $result=pg_execute($conn, "myquery", array($lon,$lat,$lon,$lat));*/
    $result = pg_query($conn, $query_progressiva);
	#echo $query;
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





?>



