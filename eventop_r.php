<?php 

session_start();

//$user = jAuth::getUserSession();


 
$subtitle="FunzionalitA  amministratore - Editing tabelle decodifiche";


$getfiltri=$_GET["f"];
$filtro_evento_attivo=$_GET["a"];
$schema= $_GET["s"];
$tabella= $_GET["t"];
//$login = $_GET["login"];
$login = 'catastostrade';
$id = $_GET["id"];


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

require('./conn.php');

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
            <!--a href="./eventop.php" class="btn btn-warning"><i class="fas fa-redo-alt"></i> Cambia evento puntuale da editare</a-->
            
            </h4> 

      </div>

        <form action="amministratore/new_eventop.php?s=<?php echo $schema;?>&t=<?php echo $tabella;?>&id='<?php echo $r0['id']?>'" method="POST">

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
					} else if ($r['column_name']== 'id_grupposegnale' or $r['column_name']== 'id_pubblicita' or $r['column_name']== 'id_concessione' ){
						
					?>
					<div class="form-group col-lg-6">
					<label for="id_civico"><?php echo $r['column_name']?></label> *
					<input type="number" value='<?php echo $id?>' name="<?php echo $r['column_name']?>" class="form-control" required="" readonly="" >


					</div>

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
					<label for="id_civico"><?php echo $normativa?>
					<?php if ($r['is_nullable']=='NO'){
						echo ' *';
					}?>
					</label>
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
				if ($r['data_type']!='boolean' and $r['column_name']!='id' AND $r['column_name']!='id_segnale_fisico' AND $r['column_name']!='id_pubblicita' AND $r['column_name'] !='geom' AND $r['column_name'] !='data_ins' AND $r['column_name'] !='data_agg' AND $r['column_name'] !='data_elimi' ){
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
                <label for="<?php echo $r['column_name']?>"> <?php echo $r['column_name']?> </label> * <br>
				<?php
                //if($r0[$r['column_name']]=='t'){
					echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" checked="" value="t"> Vero </label>';
					echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="f"> Falso </label>';
				//} else {
				//	echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" value="t"> Vero </label>';
				//	echo '<label class="radio-inline"><input type="radio" name="'.$r['column_name'].'" checked="" value="f"> Falso </label>';
				//}
				echo '</div>';
			}
			}
			}
			?>
			


        </div>   
		<div class="row">
			  
        <div class="form-group col-lg-6">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Salva nuovo elemento nella tabella <?php echo $eventop;?></button>
        </div> 
		 
		<div class="form-group col-lg-6">
         	<a href="./eventop.php" class="btn btn-warning"><i class="fas fa-redo-alt"></i> Annulla</a>
		</div>

		</div>
            </form>


<br><br>



<?php
} 

?>            



<hr>

            
            
    </div>
    <!-- /#wrapper -->



<?php 

//require('./footer.php');

require('./req_bottom.php');


?>


    
</body>



</html>
