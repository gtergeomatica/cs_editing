<?php 


require('./conn.php');


$subtitle="FunzionalitA  amministratore - Editing tabelle decodifiche";


$getfiltri=$_GET["f"];
$filtro_evento_attivo=$_GET["a"];
$schema= $_GET["s"];
$tabella= $_GET["t"];

$eventol0 = explode("_", $tabella);
$eventol = $eventol0[1];

$login = $_GET["login"];

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

    <title>Aggiunta elemento lineare</title>
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


            <h4><i class="fas fa-edit"></i> Nuovo elemento lineare nella tabella <i><?php echo $schema;?>.<?php echo $tabella;?> (<?php echo $eventol;?>)</i> - 
            <a href="./eventol.php?login=<?php echo $login;?>" class="btn btn-warning"><i class="fas fa-redo-alt"></i> Cambia evento lineare da editare</a>
            
            </h4> 

      </div>

        <form action="amministratore/new_eventol.php?s=<?php echo $schema;?>&t=<?php echo $tabella;?>&id='<?php echo $r0['id']?>'" method="POST">

		<div class="row">


			<?php 
			$query="select * from information_schema.columns WHERE table_schema='".$schema."' and table_name ilike '".$tabella."';";
			//echo $query;
			$result = pg_query($conn, $query);
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
					
					
					} else if ($r['column_name']== 'prog_ini' OR $r['column_name']== 'prog_fin'){
						
					?>
					<div class="form-group col-lg-6">
					<label for="id_civico"><?php echo $r['column_name'];?></label> *
					<input type="number" value='<?php echo $r0[$r['column_name']]?>' name="<?php echo $r['column_name']?>" class="form-control" required="" >


					</div>

					<?php
					} else if (substr($r['column_name'],0,2) == 'd_'){
					$normativa = substr($r['column_name'],2);
					$query_n="select * from normativa.".$eventol."_".$normativa." order by descrizione";
					
					//echo $query_n;
					
				?>	
					<div class="form-group col-lg-6">
					<label for="id_civico"><?php echo $normativa?> 
					<?php    
					if ($r['is_nullable']=='NO'){
						echo ' *';
					}
					?></label>
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
				if ($r['data_type']!='boolean' and $r['column_name']!='id' 
				AND $r['column_name'] !='geom' AND $r['column_name'] !='data_ins' 
				AND $r['column_name'] !='data_agg' AND $r['column_name'] !='data_elimi' 
				AND $r['column_name'] !='prog_ini_storico' 
				AND $r['column_name'] !='prog_fin_storico' 
				AND $r['column_name'] !='prog_ini_reale' 
				AND $r['column_name'] !='prog_fin_reale'
				AND $r['column_name'] !='scheda_vincolo' 
				AND $r['column_name'] !='scheda_tecnica' 
				AND $r['column_name'] !='foto'				
				){
			?>
				<div class="form-group col-lg-6">
                <?php 
				if (substr($r['column_name'],0,5) == 'data_'){
				?>	
					<label for="<?php echo $r['column_name']?>"> <?php echo $r['column_name']?> (aaaa-mm-gg)</label> 
				<?php 
				} else {
				?>	
					<label for="<?php echo $r['column_name']?>"> <?php echo $r['column_name']?></label>
                <?php
				}    
				if ($r['is_nullable']=='NO'){
            	echo '*';
            }
            ?>


				<?php
            if ($r['data_type']=='numeric'){
            	echo '<input type="number" step="0.01"';
            
            } else if ($r['data_type']=='integer'){
               echo '<input type="number" step="1"'; 
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
				<?php } else if ($r['column_name'] =='id' OR $r['column_name'] =='geom' OR $r['column_name'] =='data_ins' OR $r['column_name'] =='data_agg' 
				OR $r['column_name'] =='data_elimi' 
				OR $r['column_name'] =='prog_ini_storico' 
				OR $r['column_name'] =='prog_fin_storico' 
				OR $r['column_name'] =='prog_ini_reale' 
				OR $r['column_name'] =='prog_fin_reale' 
				OR $r['column_name'] =='scheda_vincolo' 
				OR $r['column_name'] =='scheda_tecnica' 
				OR $r['column_name'] =='foto'
				){ ?>
				
				<!-- non si fa nulla -->
				
				
  
				<?php } else if ($r['data_type']=='boolean') { ?>
				<div class="form-group col-lg-6">
                <label for="<?php echo $r['column_name']?>"> <?php echo $r['column_name']?> </label> * <br>
				<?php
                //if($r0[$r['column_name']]=='t'){
					echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="t"> Vero </label>';
					echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="f"> Falso </label>';
					echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value=""> Non specificato </label>';
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
            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Salva nuovo elemento nella tabella <?php echo $eventol;?></button>
		</div>

		<div class="form-group col-lg-6">	
			<a href="./eventol.php?login=<?php echo $login;?>" class="btn btn-warning"><i class="fas fa-redo-alt"></i> Annulla </a>
		</div>
			
		</div>
            </form>


<br><br>
NB: e possibile aggiungere schede PDF o foto (laddove consentito dall'elemento) selezionando l'elemento desiderato e modificando le informazioni ad esso associate 



<?php
} 

?>            



<hr>

<section id="c_t">
            <div class="row">

            <h4> <i class="fas fa-map-marker-alt"></i> Scelta evento lineare da editare</h4> 

<!--i class="fas fa-bezier-curve"></i-->


</div>
            <div class="row">
<form action="amministratore/scelta_tabella.php?login=<?php echo $login;?>" method="POST">

             <div class="form-group col-lg-12">
             <label for="id_civico">Seleziona tabella da editare:</label> <font color="red">*</font>
					<select class="form-control" name="table" id="table-list" class="demoInputBox" required="">
					<option  id="table" name="table" value="">Seleziona la tabella</option>
					<?php
					
					$query2="select * from information_schema.tables where table_schema ilike 'eventol' and table_name ilike 't_%' order by table_schema,table_name ";
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
