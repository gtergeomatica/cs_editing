<?php 

session_start();


$type=pg_escape_string($_GET['t']); # type geo --> geojson 

require('./conn.php');

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	if ($type=='geo'){

        $query="SELECT cod_strada, denominazione_ufficiale, 
        prog_ini, prog_fin, descrizione, note, 
        st_asgeojson(st_curvetoline(st_transform(geom, 4326))) as geometry
        FROM geometrie.route 
        WHERE flag_raccordo ='f' AND flag_rotonda ='f' 
        AND data_elimi is null AND data_cessione is null
        ORDER BY cod_strada";
        
        //echo $query;
        $result = pg_query($conn, $query);
        #echo $query;
        #exit;
        $rows = array();
        
        $geojson ='{
            "type": "FeatureCollection",
            "name": "route",
            "crs": {
            "type": "name",
            "properties": {
                "name": "EPSG:4326",
            }
            },
            "features":[';
        $k=1;
        while($r = pg_fetch_assoc($result)) {
            // popolo le Feature del geojson
            $row2 = array();
            $array2 = array (
                "cod_strada" => $r["cod_strada"],
                "denominazione_ufficiale" => $r["denominazione_ufficiale"], 
                "prog_ini" => $r["prog_ini"], 
                "prog_fin" => $r["prog_fin"], 
                "descrizione" => $r["descrizione"],
                "note"  => $r["note"]
            );
            $row2[] = $array2;
            $geom=str_replace("[{", "{",
                str_replace("}]","}",str_replace("\\", "",$r['geometry'])));
            if ($k==1){
                $geojson= $geojson.'{"type":"Feature","geometry":'.$geom;
            } else {
                $geojson= $geojson.',{"type":"Feature","geometry":'.$geom;
            }
            $geojson= $geojson. ',"properties":'.str_replace("[{", "{",
                str_replace("}]","}",json_encode(array_values($row2)).'}'));
            /*$array1 = array (
                "type" => 'Feature',
                "geometry" => $r["geometry"],
                "properties" => json_encode(array_values($row2))
            );
            $rows[] = str_replace('"properties":"', '"properties":', $array1);*/
            $rows=$array2;
            $k=$k+1;
        }
        
        pg_close($conn);
        #echo $rows ;
        if (empty($rows)==FALSE){
            //print $rows;
            #print json_encode(array_values(pg_fetch_all($result)));
            /*{
                "type": "FeatureCollection",
                "name": "b7",
                "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
                "features": [*/
            /*$geojson ='{
                "type": "FeatureCollection",
                "name": "route",
                "crs": {
                "type": "name",
                "properties": {
                    "name": "EPSG:4326",
                },
                },
                "features":['.str_replace("[{", "{",
                str_replace("}]","}", 
                    str_replace('"{', '{',
                        str_replace('}"', '}',
                            str_replace("\\", "", json_encode(array_values($rows))))))).']}';*/
            
        
            print $geojson.']}';
        } else {
            echo "[{\"NOTE\":'No data'}]";
        }
    } else {
        $query="SELECT cod_strada, denominazione_ufficiale, 
        prog_ini, prog_fin, descrizione, note
        FROM geometrie.route 
        WHERE flag_raccordo ='f' AND flag_rotonda ='f' 
        AND data_elimi is null AND data_cessione is null
        ORDER BY cod_strada";
        
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
}





?>
