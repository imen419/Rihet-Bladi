<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if ($nom && $prenom && $email && $mot_de_passe) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=inscription;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hachage du mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, email, telephone, mot_de_passe) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $telephone, $hashed_password]);

            $message = "<p class='success'>✅ Inscription réussie. Bienvenue chez Rihet Bladi !</p>";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $message = "<p class='error'>⚠️ Cet email est déjà utilisé.</p>";
            } else {
                $message = "<p class='error'>❌ Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    } else {
        $message = "<p class='error'>⚠️ Tous les champs obligatoires doivent être remplis.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Inscription Client - Rihet Bladi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background-color: #f9f9f9;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      color: #6a1b9a;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1em;
    }

    button {
      padding: 12px;
      background-color: #ff6f00;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1em;
      cursor: pointer;
    }

    button:hover {
      background-color: #e65c00;
    }

    .success {
      text-align: center;
      color: green;
      font-weight: bold;
    }

    .error {
      text-align: center;
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Créer un compte client</h2>
  <form method="POST">
    <input type="text" name="nom" placeholder="Nom *" required>
    <input type="text" name="prenom" placeholder="Prénom *" required>
    <input type="email" name="email" placeholder="Email *" required>
    <input type="text" name="telephone" placeholder="Téléphone">
    <input type="password" name="mot_de_passe" placeholder="Mot de passe *" required>
    <button type="submit">S'inscrire</button>
  </form>

  <?= $message ?>
</div>

</body>
</html>
