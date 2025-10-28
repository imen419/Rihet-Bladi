<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Commandes</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
    $(function() {
      $("#accordion").accordion();
    });
  </script>
</head>
<body>
<?php
include_once('../lib/membres.class.php');
$membre = new Membre('localhost', 'inscription', 'root', '');
$membre->Afficher_Accordillion_Commandes();
?>
</body>
</html>
