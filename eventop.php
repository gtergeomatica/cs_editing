<?php 

session_start();

require('./conn.php');


//$user = jAuth::getUserSession();



$subtitle="FunzionalitA  amministratore - Editing tabelle decodifiche";


$getfiltri=$_GET["f"];
$filtro_evento_attivo=$_GET["a"];
$schema= $_GET["s"];
$tabella= $_GET["t"];
$login = $_GET["login"];





//$db = new MyDB();

//$db = new SQLite3('../lizmap/lizmap/var/db/jauth.db');
//echo '<a href="../lizmap/lizmap/var/db/jauth.db"> link </a>';

//echo "<br> Fin qua ok!";
//$db = new SQLite3(':memory:');

//$db = new SQLite3('../lizmap/lizmap/var/db/jauth.db');

//echo "<br> Fin qua ok2!";


$user_check=0;
$query = "SELECT login, id_aclgrp FROM public.jacl2_user_group WHERE login = '".$login."';";
//print $query;
$result = pg_query($conn_l, $query);
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


$eventop0 = explode("_", $tabella);
$eventop = $eventop0[1];




//echo $filtro_evento_attivo; 


$uri=basename($_SERVER['REQUEST_URI']);
//echo $uri;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Aggiunta elemento puntuale</title>
<?php 
require('./req.php');


//require('./check_evento.php');

//require('./tables/filtri_segnalazioni.php');
?>
    
</head>

<body>

       <div class="container">



  


<?php
if($_GET["s"] != '' and $_GET["t"] != ''){

?>

            
           
     	<div class="row">


            <h4><i class="fas fa-edit"></i> Nuovo elemento nella tabella <i><?php echo $schema;?>.<?php echo $tabella;?> (<?php echo $eventop;?>)</i> - 
            <a href="./eventop.php?login=<?php echo $login;?>" class="btn btn-warning"><i class="fas fa-redo-alt"></i> Cambia evento puntuale da editare</a>
            
            </h4> 

      </div>

        <form action="amministratore/new_eventop.php?s=<?php echo $schema;?>&t=<?php echo $tabella;?>&id='<?php echo $r0['id']?>'" method="POST">

		<div class="row">


			<?php 
			//$query="select * from information_schema.columns WHERE table_schema='".$schema."' and table_name ilike '".$tabella."';";
			$query="select * from information_schema.columns WHERE table_schema=$1 and table_name ilike $2;";
			//echo $query;
			//$result = pg_query($conn, $query);
			$result = pg_prepare($conn, "myquery0", $query);
			$result = pg_execute($conn, "myquery0", array($schema, $tabella));
			#exit;
			while($r = pg_fetch_assoc($result)) {
				
				
				
				//***************
				//lato
				//***************
				if ($r['column_name']=='d_lato') { 
				$normativa = substr($r['column_name'],2);					
				$query_n="select * from normativa.". $normativa." order by descrizione";
				//$query_n="SELECT distinct(cod_strada) FROM geometrie.elementi_stradali;";
				?>
				<div class="form-group col-lg-6">
				<label for="id_civico"><?php echo $normativa?>*</label>
				<select class="form-control" name="<?php echo $r['column_name']?>" id="<?php echo $r['column_name']?>-list" class="demoInputBox" required="">
				<option  id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="">...</option>
				
				<?php
					
					$result_n = pg_query($conn, $query_n);
					
					while($r_n = pg_fetch_assoc($result_n)) {
						?>
								
							<option id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="<?php echo $r_n['id'];?>" ><?php echo $r_n['descrizione'];?></option>
					 <?php 
					 } 
					echo "</select> </div>";
				
				
				
				
				
				//***************
				//origine
				//***************				
				 } else if ($r['column_name']=='d_origine') { 
				$normativa = substr($r['column_name'],2);					
				$query_n="select * from normativa.". $normativa." order by descrizione";
				//$query_n="SELECT distinct(cod_strada) FROM geometrie.elementi_stradali;";
				?>
				<div class="form-group col-lg-6">
				<label for="id_civico"><?php echo $normativa?>*</label>
				<select class="form-control" name="<?php echo $r['column_name']?>" id="<?php echo $r['column_name']?>-list" class="demoInputBox" required="">
				<option  id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="">...</option>
				
				<?php
					
					$result_n = pg_query($conn, $query_n);
					
					while($r_n = pg_fetch_assoc($result_n)) {
						?>
								
							<option id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="<?php echo $r_n['id'];?>" ><?php echo $r_n['descrizione'];?></option>
					 <?php 
					 } 
					echo "</select> </div>";
					
					
					
					
				//***************
				//cod_strada
				//***************				
				 } else if ($r['column_name']=='cod_strada') { 
									
				
				$query_n="SELECT distinct(cod_strada) as cod FROM geometrie.elementi_stradali ORDER BY cod_strada;";
				?>
				<div class="form-group col-lg-6">
				<label for="id_civico"><?php echo $r['column_name']?>*</label>
				<select class="form-control" name="<?php echo $r['column_name']?>" id="<?php echo $r['column_name']?>-list" class="demoInputBox" required="">
				<option  id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value=""> ... </option>
				
				<?php
					
					$result_n = pg_query($conn, $query_n);
					
					while($r_n = pg_fetch_assoc($result_n)) {
						?>
								
							<option id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="<?php echo $r_n['cod'];?>" ><?php echo $r_n['cod'];?></option>
					 <?php 
					 } 
					echo "</select> </div>";
					
					
					} else if ($r['column_name']== 'login'){
						
					?>
					<div class="form-group col-lg-6">
					<label for="id_civico">User</label> *
					<input type="text" value="<?php echo $login; ?>" name="<?php echo $r['column_name']?>" class="form-control" readonly="" required="" >


					</div>

					<?php
					


					// a_ sono allegati?

					//***************
					// fk_richiedente --> r_conpub_anagrichiedenti (va fatto con Jquery vedi esempio provincia --> comune )
					//***************				
					} else if ($r['column_name']=='fk_richiedente') {
					$normativa = 'r_conpub_anagrichiedenti';
					$title	= 'Richiedente';				
					$query_n="select id, nome, cognome from eventop.". $normativa." order by cognome";
					//$query_n="SELECT distinct(cod_strada) FROM geometrie.elementi_stradali;";
					?>
					<div class="form-group col-lg-6">
					<label for="id_civico"><?php echo $title?>*</label>
					<select class="form-control" name="<?php echo $r['column_name']?>" id="<?php echo $r['column_name']?>-list" class="demoInputBox" required="">
					<option  id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="">...</option>
					
					<?php
						
						$result_n = pg_query($conn, $query_n);
						
						while($r_n = pg_fetch_assoc($result_n)) {
							?>
									
								<option id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="<?php echo $r_n['id'];?>" ><?php echo $r_n['cognome'] .' '.$r_n['nome'];?></option>
						<?php 
						}
						
						?>
						</select> 
						<small> Se il richiedente non fosse presente in lista 
						<a href=>cliccare qua
						</a> per aggiungerla</small> </div>
						<?php


					//***************
					// fk_ditta --> r_conpub_anagditte
					//***************				
					} else if ($r['column_name']=='fk_ditta') {
						$normativa = 'r_conpub_anagditte';
						$title	= 'Ditta';				
						$query_n="select * from eventop.". $normativa." order by rag_sociale";
						//$query_n="SELECT distinct(cod_strada) FROM geometrie.elementi_stradali;";
						?>
						<div class="form-group col-lg-6">
						<label for="id_civico"><?php echo $title?>*</label>
						<select class="form-control" name="<?php echo $r['column_name']?>" id="<?php echo $r['column_name']?>-list" class="demoInputBox" required="">
						<option  id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="">...</option>
						
						<?php
							
							$result_n = pg_query($conn, $query_n);
							
							while($r_n = pg_fetch_assoc($result_n)) {
								?>
										
									<option id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="<?php echo $r_n['id'];?>" ><?php echo $r_n['rag_sociale'];?></option>
							<?php 
							}
							
							?>
							</select> 
							<small> Se la ditta non fosse presente in lista 
							<a href=>cliccare qua
							</a> per aggiungerla</small> </div>
							<?php 
					

					
					

					} else if ($r['column_name']== 'prog_ini'){
						
					?>
					<div class="form-group col-lg-6">
					<label for="id_civico">progressiva</label> *
					<input type="number" value='<?php echo $r0[$r['column_name']]?>' name="<?php echo $r['column_name']?>" class="form-control" required="" >


					</div>

					<?php
					} else if (substr($r['column_name'],0,2) == 'd_'){
					$normativa = substr($r['column_name'],2);
					$query_n="select * from normativa.".$eventop."_".$normativa." order by descrizione";
					
					//echo $query_n;
					
				?>	
					<div class="form-group col-lg-6">
					<label for="id_civico"><?php echo $normativa?></label>
					<?php    
					if ($r['is_nullable']=='NO'){
						echo ' *';
					}
					?>
					<select class="form-control" name="<?php echo $r['column_name']?>" id="<?php echo $r['column_name']?>-list" class="demoInputBox" 
					
					<?php    
				if ($r['is_nullable']=='NO'){
            	echo 'required=""';
            }
            ?>
            
            >
					
					
					<option  id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="">...</option>
					
					<?php
					
					$result_n = pg_query($conn, $query_n);
					
					while($r_n = pg_fetch_assoc($result_n)) {
						?>
								
							<option id="<?php echo $r['column_name']?>" name="<?php echo $r['column_name']?>" value="<?php echo $r_n['id'];?>" ><?php echo $r_n['descrizione'];?></option>
					 <?php 
					 } 
					echo "</select> </div>";	            
					
				} else {
				
				// d_lato, d_origine, cod_strada da fare un select
				
				// geom e 3 date da nascondere
				if ($r['data_type']!='boolean' and $r['column_name']!='id' AND $r['column_name'] !='geom' AND $r['column_name'] !='data_ins' AND $r['column_name'] !='data_agg' AND $r['column_name'] !='data_elimi' ){
			?>
				<div class="form-group col-lg-6">
                <label for="<?php echo $r['column_name']?>"> <?php echo $r['column_name']?></label> 
                <?php    
				if ($r['is_nullable']=='NO'){
            	echo '*';
            }
            ?>


				<?php
            if ($r['data_type']=='numeric'){
            	echo '<input type="number" step="0.01"';
            
            } else if ($r['data_type']=='integer'){
               echo '<input type="number" step="1"'; 
            } else if ($r['data_type']=='date'){
				echo '<input type="date"'; 
			} else {    
                echo '<input type="text"'; 
            }
            ?>
                
                value="<?php echo $r0[$r['column_name']]?>" name="<?php echo $r['column_name']?>" class="form-control" 
                
            <?php    
				if ($r['is_nullable']=='NO'){
            	echo 'required=""';
            }
            ?>
            
            >
				</div>
				<?php } else if ($r['column_name'] =='id' OR $r['column_name'] =='geom' OR $r['column_name'] =='data_ins' OR $r['column_name'] =='data_agg' OR $r['column_name'] =='data_elimi' ){ ?>
				
				<!-- non si fa nulla -->
				
				
  
				<?php } else if ($r['data_type']=='boolean') { ?>
				<div class="form-group col-lg-6">
                <label for="<?php echo $r['column_name']?>"> <?php echo $r['column_name']?> </label> 
				<?php
				if ($r['is_nullable']=='NO'){
            			echo '*';
            	} ?>
				<br>
				<?php
                //if($r0[$r['column_name']]=='t'){
					echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="t" ';
					   
					if ($r['is_nullable']=='NO'){
            			echo 'required=""';
            		}
					echo '> Vero </label> ';
					echo ' <label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="f"> Falso </label>';
				//} else {
				//	echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="t"> Vero </label>';
				//	echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" checked="" value="f"> Falso </label>';
				//}
				echo '</div>';
			}
			}
			}
			?>
			


              

			  
        <div class="form-group col-lg-6">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Salva nuovo elemento nella tabella <?php echo $eventop;?></button>
        </div> 
		 
		<div class="form-group col-lg-6">
         	<a href="./eventop.php?login=<?php echo $login;?>" class="btn btn-warning"><i class="fas fa-redo-alt"></i> Annulla</a>
		</div>

		</div>
            </form>


<br><br>



<?php
} 

?>            



<hr>

<section id="c_t">
            <div class="row">

            <h4> <i class="fas fa-map-marker-alt"></i> Scelta evento puntuale da editare</h4> 

<!--i class="fas fa-bezier-curve"></i-->


</div>
            <div class="row">
<form action="amministratore/scelta_tabella.php?login=<?php echo $login;?>" method="POST">

             <div class="form-group col-lg-12">
             <label for="id_civico">Seleziona tabella da editare:</label> <font color="red">*</font>
					<select class="form-control" name="table" id="table-list" class="demoInputBox" required="">
					<option  id="table" name="table" value="">Seleziona la tabella</option>
					<?php
					
					$query2="select * from information_schema.tables where table_schema ilike 'eventop' and table_name ilike 't_%' order by table_schema,table_name ";
					//echo $query2;
					$result2 = pg_query($conn, $query2);
					 
					while($r2 = pg_fetch_assoc($result2)) { 
						$valore=  $r2['cf']. ";".$r2['nome'];            
					?>
								
							<option id="table" name="table" value="<?php echo $r2['table_schema'];?>.<?php echo $r2['table_name'];?>" ><?php echo $r2['table_schema'];?>.<?php echo $r2['table_name'];?></option>
					 <?php } ?>
				</select>
				
             </div>
             
             
             
      
             
             


				</div> 


				
				
            <!--div class="row"-->

            <div class="row">

					   


            <button  type="submit" class="btn btn-warning"> <i class="fas fa-list"></i> Compila attributi evento </button>
            </div>
            <!-- /.row -->
            

            </form> 


</section>

            
            
    </div>
    <!-- /#wrapper -->



<?php 

//require('./footer.php');

require('./req_bottom.php');


?>


    
</body>



</html>
