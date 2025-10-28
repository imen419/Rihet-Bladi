<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
  </script>
</head>
<body>
<?php
//compléter le code PHP 
include_once('../lib/membres.class.php');
$membre=new Membre('localhost','inscription','root','');
$membre->Afficher_Accordillion2();

?>
</body>
</html>
<script type="text/javascript">
//compléter le code JavaScript

</script>
