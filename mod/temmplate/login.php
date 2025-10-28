<?php
session_start();

// مهلة الجلسة - 30 دقيقة
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

$host = 'localhost';
$dbname = 'inscription';
$dbuser = 'root';
$dbpass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM login WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "❌ Nom d’utilisateur ou mot de passe incorrect.";
        }
    } else {
        $message = "⚠️ Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Rihet Bladi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* === STYLE DE LA CARTE === */
    .login-card {
        background-color: #1c1c1c; /* gris foncé */
        color: #ffffff;
        border-radius: 15px;
        padding: 30px;
        width: 380px;
        box-shadow: 0 0 25px rgba(255, 165, 0, 0.4); /* ombre orange */
        text-align: center;
    }

    /* === STRUCTURE GLOBALE === */
    body {
        display: flex;
        justify-content: center;  /* centré horizontalement */
        align-items: center;      /* centré verticalement */
        min-height: 100vh;        /* hauteur de l’écran */
        margin: 0;
        background-color: #000;   /* fond noir */
        flex-direction: column;   /* pour garder la nav au-dessus */
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
        width: 100%;
        position: fixed;  /* toujours visible en haut */
        top: 0;
        left: 0;
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

    /* === FORMULAIRE === */
    .form-control {
        background-color: #2a2a2a;
        border: 1px solid #444;
        color: #fff;
    }

    .form-control:focus {
        border-color: orange;
        box-shadow: 0 0 8px orange;
        background-color: #2f2f2f;
        color: #fff;
    }

    .btn-orange {
        background-color: orange;
        border: none;
        font-weight: bold;
        color: black;
    }

    .btn-orange:hover {
        background-color: #ff8c00;
        color: white;
    }

    a {
        color: orange;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
        color: #ff8c00;
    }

    /* Décalage pour ne pas cacher la carte sous la navbar */
    .content {
        margin-top: 100px;
    }
</style>

</head>

<body>
  <!-- === HEADER & NAV === -->
  <header>
    <div class="nav-yassir">
      <div class="logo-yassir">
        <img src="images/Logo rbt3.png" alt="Logo">
        <span>Rihet <strong>Bladi</strong></span>
      </div>
      <ul class="nav-links">
        <li><a href="business.php">Business</a></li>
        <li><a href="login.php">Connexion</a></li>
        <li><a href="chatbot.php">Chatbot</a></li>
        <li><a href="livraison.php">Livraison</a></li>
        <li><a href="Commande.php">Commande</a></li>
        <li><a href="partenaires.html">Partenaires</a></li>
      </ul>
    </div>
  </header>

  <!-- === MAIN CONTENT === -->
  <main>
    <div class="login-card">
      <h3 class="text-center mb-4">Se connecter</h3>
      <?php if (isset($message) && $message): ?>
        <div class="alert alert-danger text-center"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3 text-start">
          <label class="form-label">Nom d’utilisateur</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3 text-start">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-orange w-100">Connexion</button>
      </form>

      <p class="text-center mt-3">
        Pas de compte ? <a href="register.php">Créer un compte</a>
      </p>
    </div>
  </main>

</body>
</html>