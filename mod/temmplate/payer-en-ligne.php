<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $montant = floatval($_POST['montant'] ?? 0);
    $mode_paiement = htmlspecialchars(trim($_POST['mode_paiement'] ?? ''));

    if ($nom && $email && $montant > 0 && $mode_paiement) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=inscription;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO paiements (nom, email, montant, mode_paiement) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $montant, $mode_paiement]);

            $message = "<p class='success'>✅ Paiement simulé avec succès. Merci !</p>";
        } catch (PDOException $e) {
            $message = "<p class='error'>❌ Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $message = "<p class='error'>⚠️ Veuillez remplir tous les champs correctement.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Paiement en ligne - Rihet Bladi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdfdfd;
      padding: 50px 20px;
      text-align: center;
    }

    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }

    h2 {
      color: #ff6f00;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
      text-align: left;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
 .nav-yassir {
      background-color: #ffffff;
      border-bottom: 1px solid #e0e0e0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo-yassir {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 20px;
      font-weight: bold;
      color: #0d47a1;
    }

    .logo-yassir img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #0d47a1;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    .nav-links li a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      padding: 8px 14px;
      border-radius: 10px;
      transition: background-color 0.3s, color 0.3s;
    }

    .nav-links li a:hover {
      background-color: #56CFCA;
      color: white;
    } .nav-yassir {
      background-color: #ffffff;
      border-bottom: 1px solid #e0e0e0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo-yassir {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 20px;
      font-weight: bold;
      color: #0d47a1;
    }

    .logo-yassir img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #0d47a1;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    .nav-links li a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      padding: 8px 14px;
      border-radius: 10px;
      transition: background-color 0.3s, color 0.3s;
    }

    .nav-links li a:hover {
      background-color: #56CFCA;
      color: white;
    }
    button {
      margin-top: 20px;
      background-color: orange;
      color: black;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }

    .success {
      color: green;
      font-weight: bold;
      margin-top: 20px;
    }

    .error {
      color: red;
      font-weight: bold;
      margin-top: 20px;
    }

    .note {
      font-size: 0.9em;
      color: #777;
      margin-top: 10px;
    }
    /* === NAVIGATION === */
    .nav-yassir {
      background-color: #ffffff;
      border-bottom: 1px solid #e0e0e0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo-yassir {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 20px;
      font-weight: bold;
      color: #0d47a1;
    }

    .logo-yassir img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #0d47a1;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    .nav-links li a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      padding: 8px 14px;
      border-radius: 10px;
      transition: background-color 0.3s, color 0.3s;
    }

    .nav-links li a:hover {
      background-color: #56CFCA;
      color: white;
    }

  </style>
</head>
<body>
<!-- NAVIGATION -->
<header>
  <div class="nav-yassir">
    <div class="logo-yassir">
      <img src="images/Logo rbt.png" alt="Logo Rihet Bladi">
      <span>Rihet <strong>Bladi</strong></span>
    </div>
    <ul class="nav-links">
      <li><a href="index.html">Accueil</a></li>
      <li><a href="business.php"> Business</a></li>
      <li><a href="livraison.php"> Livraison</a></li>
      <li><a href="Commande.php"> Commande</a></li>
      <li><a href="login.php"> Login</a></li>
      <li><a href="partenaires.html"> Partenaires</a></li>
    </ul>
  </div>
</header>

<form method="post" action="">
  <h2>💳 Paiement en ligne (simulation)</h2>

  <label for="nom">Nom complet :</label>
  <input type="text" name="nom" id="nom" required>

  <label for="email">Email :</label>
  <input type="email" name="email" id="email" required>

  <label for="montant">Montant à payer (TND) :</label>
  <input type="number" name="montant" id="montant" step="0.01" required>

  <label for="mode_paiement">Mode de paiement :</label>
  <select name="mode_paiement" id="mode_paiement" required>
    <option value="">-- Choisir --</option>
    <option value="Carte Bancaire">Carte Bancaire</option>
    <option value="D17 / E-Dinar">D17 / E-Dinar</option>
    <option value="Cash à la livraison">Cash à la livraison</option>
  </select>

  <button type="submit">Valider le paiement</button>

  <?= $message ?>
  <p class="note">⚠️ Ce paiement est une simulation. Aucune transaction réelle ne sera effectuée.</p>
</form>

</body>
</html>
