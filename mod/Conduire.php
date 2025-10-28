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
// Connexion à la base de données
$host = "localhost";
$dbname = "rihetbladi";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $telephone = trim($_POST['telephone'] ?? '');
    $ville = trim($_POST['ville'] ?? '');

    if (!$nom || !$prenom || !$email) {
        $message = "⚠️ Veuillez remplir tous les champs obligatoires.";
    } else {
        $stmt = $conn->prepare("INSERT INTO chauffeurs (nom, prenom, email, telephone, ville) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nom, $prenom, $email, $telephone, $ville);
        if ($stmt->execute()) {
            $message = "✅ Inscription réussie.";
        } else {
            $message = "❌ Erreur : " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription Chauffeur - Rihet Bladi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body { font-family: 'Segoe UI', sans-serif; margin:0; background:#000; color:#fff; }
    
    /* NAVIGATION */
    .nav-yassir {
      background-color: #111;
      border-bottom: 1px solid #333;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .logo-yassir { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: bold; color: #ff6600; }
    .logo-yassir img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid #ff6600; }
    .nav-links { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
    .nav-links li a { text-decoration: none; color: #fff; font-weight: 500; padding: 8px 14px; border-radius: 10px; transition: 0.3s; }
    .nav-links li a:hover { background-color: #56CFCA; color: #000; }

    /* CONTENEUR FORMULAIRE + IMAGE */
    .container { max-width: 900px; margin: 2em auto; padding: 2em; display: flex; flex-wrap: wrap; gap:2em; background:#1a1a1a; border-radius:12px; }
    .form-container { flex:1; min-width:300px; }
    .form-container h2 { color:#ff6600; text-align:center; margin-bottom:1em; }
    form { display: flex; flex-direction: column; gap:1em; }
    input { padding:0.8em; border-radius:8px; border:1px solid #555; background:#333; color:#fff; }
    input:focus { outline:none; border-color:#ff6600; box-shadow:0 0 5px #ff6600; background:#444; }
    button { padding:1em; border:none; border-radius:8px; background:#ff6600; color:#fff; cursor:pointer; }
    button:hover { background:#e65c00; }
    .message { margin-top:1em; font-weight:bold; color:#56CFCA; }

    .form-image { flex:1; text-align:center; min-width:300px; }
    .form-image img { max-width:100%; border-radius:12px; }

    @media(max-width:768px) {
        .container { flex-direction: column; }
        .form-image { margin-top:1.5em; }
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
            <li><a href="business.php">Business</a></li>
            <li><a href="livraison.php">Livraison</a></li>
            <li><a href="Commande.php">Commande</a></li>
            <li><a href="partenaires.html">Partenaires</a></li>
        </ul>
    </div>
</header>

<div class="container">
    <!-- Formulaire à gauche -->
    <div class="form-container">
        <h2>Inscription Chauffeur</h2>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom *" required>
            <input type="text" name="prenom" placeholder="Prénom *" required>
            <input type="email" name="email" placeholder="Email *" required>
            <input type="text" name="telephone" placeholder="Téléphone">
            <input type="text" name="ville" placeholder="Ville">
            <button type="submit">S'inscrire</button>
        </form>
        <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
    </div>

    <!-- Image à droite -->
    <div class="form-image">
        <img src="images/8 15 2025 (1).png" alt="Transport">
    </div>
</div>
</body>
</html>
