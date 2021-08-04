<?php





$user_check=0;
/*$query = "SELECT login, id_aclgrp FROM public.jacl2_user_group WHERE login = '".$login."';";
//print $query;
$result = pg_query($conn_l, $query);*/

$query = "SELECT login, id_aclgrp FROM public.jacl2_user_group WHERE login = $1;";
$result = pg_prepare($conn_l, "login", $query);
$result = pg_execute($conn_l, "login", array($login));


while($r = pg_fetch_assoc($result)) {
	if ($r['id_aclgrp']=='admins' OR $r['id_aclgrp']=='cs_editor_group' ){
		$user_check=1; 
	}
}


if ($user_check==1){
	echo '<i class="fas fa-user-check"></i> Utente con i permessi di editing'; 
} else {
	echo '<i class="fas fa-user-times"></i> Utente privo dei permessi di editing'; 
	exit;
}


?>