<!DOCTYPE HTML>
<html lang="fr-FR">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<form method="post" action="">
<fieldset style="width:650px; margin:auto">
<legend><b>Formulaire d'inscription</b></legend>  
<table>
<tr>
	<td> 
	<label for="pseudo"><b>* Votre pseudo:</b><label></td>
	<td> <input name="pseudo" type="text" id="pseudo" />  
	</td>
</tr>  
<tr>
	<td>
	<label for="email"><b>* Votre email:</b><label> </td> 
	<td><input name="email" type="email" id="email" />  
	</td>
</tr> 
<tr>
	<td>
	<label for="adresse"><b>* Votre adresse:</b><label></td>
	<td><input name="adresse" type="text" id="adresse" size="50"/>  
	</td>
	<td> <label for="pays"><b>* Pays:</b><label></td>
	<td><select name="pays" id="pays">
			<option value="TN">Tunisie</option>
			<option value="ALG">Algerie</option>
			<option value="MA">Maroc</option>
		</select>
	</td>
</tr>
 <tr></tr>
<tr>
	<td>
	<input  type="submit" value="S'inscrire" name="btn_inscrire"/>  
	</td>
</tr>
</table>    
<p> Les champs précédés  d'un * sont obligatoires </p>  
</fieldset>
</form>
</body>
</html>
<?php
//Appel de la classe et utilisation des methodes Ajouter et Afficher
if(isset($_POST['btn_inscrire']))
	{
	include_once('../lib/membres.class.php');
	$membre=new Membre('localhost','inscription','root','');
	$membre->pseudo=$_POST['pseudo'];
	$membre->email=$_POST['email'];
	$membre->adresse=$_POST['adresse'];
	$membre->pays=$_POST['pays'];
	if($membre->ajouter())	$membre->afficher();
	else echo 'echec d\'insertion';
	}
?>