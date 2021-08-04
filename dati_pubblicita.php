<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="it">




<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >


	<link rel="icon" href="favicon.ico"/>

    <title>Pubblicità - Lista procedimenti</title>
<!-- Richiama Stili e CSS-->
<?php
require('req.php');
?>
    

</head>

<body id="page-top">

<!-- tabella istanze aggiunte dall'utente griglia_richieste.php per i dati -->
<div>
<?php
include './conn.php';
$login = $_GET["login"];
include 'check_login.php';
?>
    <h2> <i class="fas fa-copy" style="color:white;"></i> Pubblicità (lista procedimenti) 
    
    <?php 
    echo '<a href="eventop.php?login='.$login.'&s=eventop&t=r_conpub_proc"';
    echo 'type="button" class="btn btn-info"> Nuova richiesta</a>';
    ?>
    </h2>
	<!--div id="toolbar2">
            <select class="form-control">
                <option value="">Esporta i dati visualizzati</option>
                <option value="all">Esporta tutto (lento)</option>
                <option value="selected">Esporta solo selezionati</option>
            </select>
        </div-->
	<div style="overflow-x:auto;">
    <table style="background-color:white;" id="log" class="table-hover" data-toggle="table" data-filter-control="true" 
  data-show-search-clear-button="true" data-page-size="25" 
  data-url="./tables/json_tabella.php?s=eventop&t=r_conpub_proc" 
	data-show-export="false" data-search="true" data-click-to-select="true" data-pagination="true" 
  data-sidePagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true"
   data-toolbar="#toolbar2" data-locale="it-IT" data-row-style="rowStyle">
<thead>
<!--data-field="colonna DB" data-formatter="nome funzione" -->
 <tr>
            <!--th data-field="state" data-checkbox="true"></th-->
			<th data-field="id" data-sortable="false" data-formatter="nameFormatterEdit" data-visible="true">Modifica</th>
            <th data-field="a_bozzetto" data-sortable="false" data-formatter="nameFormatterBozzetto" data-visible="true">Bozzetto</th>
            <th data-field="n_protocolllo_arrivo" data-sortable="false" data-filter-control="input" data-visible="true">Protocollo</th>
            <th data-field="data_protocollo_arrivo" data-sortable="false" data-filter-control="input" data-visible="true">Data Protocollo</th>
            <th data-field="d_fase_proc" data-formatter="nameFormatterStato" data-sortable="false" data-filter-control="select" data-visible="true">Stato procedimento</th>
        </tr>
</thead>

</table>

<script>
function nameFormatterEdit(value, row) {
	//var test_id= row.id;
	//return' <button type="button" class="btn btn-info" data-target="remove_ist.php?idu='+row.id_istanza+'"><i class="fas fa-trash-alt"></i></button>';
  if (row.d_fase_proc == 'L' || row.d_fase_proc == 'S' || row.d_fase_proc == 'SR' || row.d_fase_proc == 'NC'){
	  return ' <a type="button" class="btn btn-info" title="Editing elemento con id '+ row.id +'" href="eventop_r_u.php?t=r_conpub_proc&s=eventop&id1='+row.id+'"><i class="fas fa-edit"></i></a>';
  }else{
    return value;
  }
}
</script>


<script>
function nameFormatterBozzetto(value, row) {
    return 'TODO';
}
</script>
<?php
/**
 ('L','In lavorazione'),
 ('S','Sospensione'),
 ('P','In attesa di pagamento'),
 ('A','Autorizzazione attiva'),
 ('SR','Autorizzazione scaduta o revocata'),
 ('DR','Diniego o Rinuncia'),
 ('NC','Non classificato');
*/

?>

<script>
function nameFormatterStato(value) {
    if(value=='P'){
        return '<i class="fas fa-euro-sign" title="In attesa di pagamento"></i>';
    } else if (value=='A') {
        return '<i class="fas fa-circle" style="color:#007c37;" title="Autorizzazione attiva"></i>';
    } else if (value=='S') {
        return '<i class="fas fa-stop" style="color:#ff0000;" title="Autorizzazione sospesa"></i>';
    } else {
        return 'TODO '+value
    }
}
</script>

</div>	


</div>








<?php
//require('footer.php');
require('req_bottom.php');
?>

</html>