<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Effet Toggle</title>
<script type="text/javascript" src="../jquery/js/jquery-1.3.2.js"></script>
</head>
<body>
<?php
//compléter le code PHP 
include_once('../lib/membres.class.php');
$membre=new Membre('localhost','inscription','root','');
$membre->Afficher_Toggle();

?>
</body>
</html>
<script type="text/javascript">
	//jQuery
$('.detail').bind("click", function(e){
	var id = $(this).attr('id');//11
	$('#detail_'+id).toggle('fast');//id="detail_11"
});
</script>
