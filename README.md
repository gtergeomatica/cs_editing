# cs_editing

- pagine editing DB Catasto Strade
- WS per interazione con altri servizi
    - richiesta json dati 
    - editing su DB tramite POST request

I WS sono organizzati nei seguenti script:
    - get_coordinate.php
    - get_decodifica.php
    - get_progressiva.php
    - get_route_by_cod.php
    - get_route.php

Necessario file conn.php

```
<?php 


//DB Catasto STRADE
$conn = pg_connect("host=127.0.0.1 port=5432 dbname=XXXXX user=XXXXXXX password=XXXXXX");

if (!$conn) {
        die('Could not connect to DB, please contact the administrator.');
}
else {
        //echo ("Connected to local DB");
}



// DB LIZMAP
$conn_l = pg_connect("host=127.0.0.1 port=5432 dbname=XXXXX user=XXXXX password=XXXXXXX");

if (!$conn_l) {
        die('Could not connect to DB, please contact the administrator.');
}
else {
        //echo ("Connected to local DB");
}



?>

```

