<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'inscription';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$messageRetour = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage
    $nom      = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $plat     = htmlspecialchars(trim($_POST['plat'] ?? ''));
    $quantite = floatval($_POST['quantite'] ?? 0);
    $adresse  = htmlspecialchars(trim($_POST['adresse'] ?? ''));

    // Validation
    if ($nom === '' || !$email || $plat === '' || $quantite <= 0 || $adresse === '') {
        $messageRetour = '<p style="color:red;">Veuillez remplir tous les champs correctement.</p>';
    } else {
        // Calcul prix (exemple: 10 DT / kg)
        $prix = 10 * $quantite;

        // Insertion en base
        $stmt = $pdo->prepare("INSERT INTO commandes_chocho (nom, email, plat, quantite, adresse, prix) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $plat, $quantite, $adresse, $prix]);

        // Envoi email confirmation
        $to = $email;
        $subject = "Confirmation de votre commande Rihet Bladi";
        $message = "Bonjour $nom,\n\nMerci pour votre commande de $quantite kg de $plat.\nAdresse de livraison : $adresse\nMontant total : $prix TND.\n\nNous vous contacterons bientôt.\n\n— L'équipe Rihet Bladi";
        $headers = "From: no-reply@rihetbladi.tn";

        mail($to, $subject, $message, $headers);

        $messageRetour = '<p style="color:green;">✅ Commande enregistrée avec succès. Un email de confirmation a été envoyé à ' . htmlspecialchars($email) . '.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Passer commande - Rihet Bladi</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin: 0; padding: 0;
  }
  .container {
    max-width: 600px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
  h1 {
    text-align: center;
    color: #f57c00;
    margin-bottom: 20px;
  }
  form label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
  }
  form input, form select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
  }
  form button {
    margin-top: 25px;
    width: 100%;
    background: #f57c00;
    color: white;
    font-weight: bold;
    border: none;
    padding: 14px;
    border-radius: 30px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  form button:hover {
    background: #e65c00;
  }
  .message {
    text-align: center;
    font-size: 1.1rem;
    margin-bottom: 20px;
  }
  commande-image {
  flex: 1 1 300px;           /* صورة تأخذ مساحة مناسبة */
  text-align: left;
}

.commande-image img {
  max-width: 100%;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

</style>
</head>
<body>
  <header>

 <div class="nav-yassir">
    <div class="logo-yassir">
      <img src="images/Logo rbt.png" alt="Logo Rihet Bladi">
      <span>Rihet <strong>Bladi</strong></span>
    </div>
    <ul class="nav-links">
      <li><a href="index.html">Accueil</a></li>
      <li><a href="business.php">Business</a></li>
      <li><a href="livraison.php">Livraison</a></li>
      <li><a href="commande.php">Commande</a></li>
      <li><a href="partenaires.html">Partenaires</a></li>
    </ul>
  </div>
</header>

<div class="container">
  <h1>Commande spéciale de madam chocho</h1>

  <?php
  if ($messageRetour) {
      echo '<div class="message">' . $messageRetour . '</div>';
  }
  ?>
<div class="commande-image">
            <img src="images/RIHITBLED.png " alt="Lablabi">


  </div>
  <form method="post" action="">
    <label for="nom">Nom complet :</label>
    <input type="text" id="nom" name="nom" required placeholder="Votre nom complet" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>" />

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required placeholder="Votre email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />

    <label for="plat">Choisissez un plat :</label>
    <select id="plat" name="plat" required>
      <option value="">-- Sélectionner --</option>
      <option value="Couscous" <?= (isset($_POST['plat']) && $_POST['plat'] === 'Couscous') ? 'selected' : '' ?>>Couscous</option>
      <option value="Mloukhia" <?= (isset($_POST['plat']) && $_POST['plat'] === 'Mloukhia') ? 'selected' : '' ?>>Mloukhia</option>
      <option value="Ojja" <?= (isset($_POST['plat']) && $_POST['plat'] === 'Ojja') ? 'selected' : '' ?>>Ojja</option>
      <option value="Tajine" <?= (isset($_POST['plat']) && $_POST['plat'] === 'Tajine') ? 'selected' : '' ?>>Tajine</option>
    </select>

    <label for="quantite">Quantité (kg) :</label>
    <select id="quantite" name="quantite" required>
      <option value="">-- Sélectionner --</option>
      <option value="0.5" <?= (isset($_POST['quantite']) && $_POST['quantite'] == 0.5) ? 'selected' : '' ?>>0.5</option>
      <option value="1" <?= (isset($_POST['quantite']) && $_POST['quantite'] == 1) ? 'selected' : '' ?>>1</option>
      <option value="1.5" <?= (isset($_POST['quantite']) && $_POST['quantite'] == 1.5) ? 'selected' : '' ?>>1.5</option>
      <option value="2" <?= (isset($_POST['quantite']) && $_POST['quantite'] == 2) ? 'selected' : '' ?>>2</option>
      <option value="3" <?= (isset($_POST['quantite']) && $_POST['quantite'] == 3) ? 'selected' : '' ?>>3</option>
    </select>

    <label for="adresse">Adresse de livraison :</label>
    <input type="text" id="adresse" name="adresse" required placeholder="Votre adresse complète" value="<?= isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : '' ?>" />

    <button type="submit">Valider la commande</button>
  </form>
</div>

</body>
</html>
