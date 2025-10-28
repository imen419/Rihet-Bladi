<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<script type="text/javascript" src="../jquery2/js/jquery.js"></script>
<script type="text/javascript" src="../jquery2/js/affichage.js"></script>

<link rel="stylesheet" href="../jquery2/affichage.css" media="screen" />
</head>
<body>
<?php
//compléter le code PHP 
include_once('../lib/membres.class.php');
$membre=new Membre('localhost','inscription','root','');
$membre->Afficher_Accordillion();

?>
</body>
</html>
<script type="text/javascript">
//compléter le code JavaScript

</script>
