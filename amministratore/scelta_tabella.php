<?php


$str= $_POST["table"];

$login = $_GET["login"];

$table0 = explode(".", $str);

$schema=$table0[0];

$table=$table0[1];


//echo $schema;
//echo "<br>";
//echo $table;


// redirect verso pagina interna

header("location: ../".$schema.".php?login=".$login."&s=".$schema."&t=".$table."");


?>