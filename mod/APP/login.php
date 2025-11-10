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
        body {
            background: linear-gradient(135deg, #000000, #2c2c2c); /* خلفية سوداء مع رمادي */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background-color: #1c1c1c; /* رمادي داكن */
            color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            width: 380px;
            box-shadow: 0 0 25px rgba(255, 165, 0, 0.4); /* ظل برتقالي */
        }
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
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card">
        <h3 class="text-center mb-4">Se connecter</h3>
        <?php if ($message): ?>
            <div class="alert alert-danger text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nom d’utilisateur</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-orange w-100">Connexion</button>
        </form>
        <p class="text-center mt-3">
            Pas de compte ? <a href="register.php">Créer un compte</a>
        </p>
    </div>
</body>
</html>
