<?php 

session_start();

require('./conn.php');
/*Data una coppia di coordinate geografche (lon, lat)
 il servizio get_progressiva restituisce la progressiva, il codice strada e le coordinate del punto non snappato*/ 

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$lat = pg_escape_string($_GET["lat"]);
	$lon = pg_escape_string($_GET["lon"]);
	if ($lat =='' or $lon ==''){
		die('[{"ERROR":"Il WS richiede come parametri sia la latitudine che la longitudine. Verifica di averli correttamente inseriti"}]');
	}
    
    /*$query_progressiva= "with prog as (
        SELECT round(v.prog_ini::numeric, 0)+
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
            )*ST_Length(v.geom))::numeric,0) as progressiva, v.cod_strada, 
            st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) as input_geom
            FROM geometrie.elementi_stradali v 
            order by ST_Distance( v.geom , st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) )
            limit 1)
           select prog.progressiva, prog.cod_strada, n.cod_catastale, $lon as input_lon, $lat as input_lat  
        FROM prog, normativa.comuni_corretti n
        WHERE ST_Intersects(prog.input_geom, n.geom);";

*/

        
        $query_progressiva= "with prog as (
            SELECT round(v.prog_ini::numeric, 0)+
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
                )*ST_Length(v.geom))::numeric,0) as progressiva, v.cod_strada, 
                st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) as input_geom
                FROM geometrie.elementi_stradali v 
                order by ST_Distance( v.geom , st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) )
                limit 1),
     flag as (select 
             st_dwithin(tc.geom, snapped.geom, 5) as f_centro_abitato  --soglia di 5 metri come margine di errore
             from  eventol.t_centriabitati tc ,
                    (select ST_ClosestPoint(v.geom , 
                                            st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) 
                     ) as geom 
                     FROM geometrie.elementi_stradali v 
                     order by ST_Distance( v.geom , st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632) )
                     limit 1) as snapped
                     order by ST_Distance( tc.geom , st_transform(ST_GeomFromText('POINT(".$lon." ".$lat." 0)',4326),32632))
                     limit 1            
                ) 
            select prog.progressiva, prog.cod_strada, n.cod_catastale, flag.f_centro_abitato, $lon as input_lon, $lat as input_lat  
            FROM prog, normativa.comuni_corretti n, flag
            WHERE ST_Intersects(prog.input_geom, n.geom);";




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



