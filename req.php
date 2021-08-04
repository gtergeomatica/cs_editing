<?php 

//$page = $_SERVER['PHP_SELF'];
//$sec = "60";


function integerToRoman($integer)
{
 // Convert the integer into an integer (just to make sure)
 $integer = intval($integer);
 $result = '';
 
 // Create a lookup array that contains all of the Roman numerals.
 $lookup = array('M' => 1000,
 'CM' => 900,
 'D' => 500,
 'CD' => 400,
 'C' => 100,
 'XC' => 90,
 'L' => 50,
 'XL' => 40,
 'X' => 10,
 'IX' => 9,
 'V' => 5,
 'IV' => 4,
 'I' => 1);
 
 foreach($lookup as $roman => $value){
  // Determine the number of matches
  $matches = intval($integer/$value);
 
  // Add the same number of characters to the string
  $result .= str_repeat($roman,$matches);
 
  // Set the integer to be the remainder of the integer and the value
  $integer = $integer % $value;
 }
 
 // The Roman numeral should be built, return it
 return $result;
}

?>

<!-- REFRESH automatico pagine -->
     <!--meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'" content="IE=edge"-->

<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>



<!-- Bootstrap Core CSS -->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--link href="../vendor/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet"-->

    <!-- Custom Fonts -->
    <link href="fontawesome-free-5.8.1-web/css/all.css" rel="stylesheet" type="text/css">
    
    
    


     <!-- Bootstrap Table CSS -->
	<link rel="stylesheet" href="./bootstrap-table/dist/bootstrap-table.min.css" >
	<!--link rel="stylesheet" href="./bootstrap-table/dist/extensions/export/bootstrap-table-export.css" -->
	<link rel="stylesheet" href="./bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.css" >


    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- jQuery -->
<script src="jquery/jquery-3.6.0.min.js"></script>
<!--script src="./jquery/dist/jquery.min.js"></script-->


<?php
?>
