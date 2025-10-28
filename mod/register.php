

<?php
$host = 'sql105.infinityfree.com';
$dbname = 'if0_39873671_rihitbledi';
$dbuser = 'if0_39873671';
$dbpass = 'لمة_المرور_ك';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // الاتصال ناجح
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>


<?php
session_start();

// Connexion à la base
$host = 'localhost';
$dbname = 'inscription';
$dbuser = 'root';
$dbpass = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $password_confirm = $_POST['password_confirm'] ?? '';

  if (!$username || !$email || !$password || !$password_confirm) {
    $message = "Veuillez remplir tous les champs.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Adresse e-mail invalide.";
  } elseif ($password !== $password_confirm) {
    $message = "Les mots de passe ne correspondent pas.";
  } else {
    $stmt = $pdo->prepare("SELECT id FROM login WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
      $message = "Nom d’utilisateur ou e-mail déjà utilisé.";
    } else {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare("INSERT INTO login (username, email, password_hash) VALUES (?, ?, ?)");
      if ($stmt->execute([$username, $email, $password_hash])) {
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
      } else {
        $message = "Une erreur est survenue lors de l'inscription.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription - Rihet Bladi</title>
<style>
:root {
  --orange: #e910afff;
  --turquoise: #56CFCA;
  --white: #ffffff;
  --dark: #333333;
}
body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background-color: var(--white);
}
.container {
  display: flex;
  height: 100vh;
}
.left {
  flex: 1;
  background-color: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
}
.left img {
  max-width: 90%;
  max-height: 90%;
  border-radius: 15px;
  box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
}
.right {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--white);
}
.form-box {
  width: 100%;
  max-width: 400px;
  padding: 30px;
}
h2 {
  color: #151415ff;
  margin-bottom: 20px;
  text-align: center;
}
label {
  display: block;
  margin-bottom: 6px;
  font-weight: 500;
}
input {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1.5px solid var(--turquoise);
  border-radius: 8px;
  font-size: 14px;
}
input:focus {
  border-color: var(--orange);
  outline: none;
}
button {
  width: 100%;
  padding: 12px;
  background: var(--orange);
  border: none;
  border-radius: 8px;
  color: var(--white);
  font-weight: bold;
  font-size: 15px;
  cursor: pointer;
}
button:hover {
  background: #c51ed1ff;
}
.message {
  text-align: center;
  margin-bottom: 15px;
  color: red;
  font-size: 14px;
}
p {
  text-align: center;
  font-size: 13px;
}
p a {
  color: var(--turquoise);
  text-decoration: none;
}
@media(max-width: 900px) {
  .container {
    flex-direction: column;
  }
  .left {
    height: 200px;
  }
}
 body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff;
      color: #333;
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
    <header>
    <div class="nav-yassir">
      <div class="logo-yassir">
        <img src="images/Logo rbt.png" alt="Logo">
        <span>Rihet <strong>Bladi</strong></span>
      </div>
      <ul class="nav-links">
        <li><a href="business.php"> Business</a></li>
        <li><a href="login.php">Connexion </a></li>
        <li><a href="livraison.php"> Livraison</a></li>
        <li><a href="Commande.php"> Commande</a></li>
        <li><a href="partenaires.html"> Partenaires</a></li>
      </ul>
    </div>
  </header>
<div class="container">
  <div class="left">
        <img src="images/5 (7).png" alt="Couscous">

  </div>
  <div class="right">
    <div class="form-box">
      <h2>Créer un compte</h2>
      <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>
      <form method="POST">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
        <label for="password_confirm">Confirmez le mot de passe</label>
        <input type="password" id="password_confirm" name="password_confirm" required>
        <button type="submit">S'inscrire</button>
      </form>
      <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
  </div>
</div>
</body>
</html>
