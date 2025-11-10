<?php
$host = "localhost";
$dbname = "inscription";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $ville = htmlspecialchars(trim($_POST['ville']));

    if ($nom && $prenom && $email) {
        $check = $conn->prepare("SELECT id FROM vendeurs WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "⚠️ Cet email est déjà utilisé.";
            $message_type = "error";
        } else {
            $stmt = $conn->prepare("INSERT INTO vendeurs (nom, prenom, email, telephone, ville) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nom, $prenom, $email, $telephone, $ville);

            if ($stmt->execute()) {
                $message = "✅ Inscription réussie.";
                $message_type = "success";
            } else {
                $message = "❌ Erreur : " . $stmt->error;
                $message_type = "error";
            }
            $stmt->close();
        }
        $check->close();
    } else {
        $message = "⚠️ Veuillez remplir tous les champs obligatoires.";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription Vendeur - Rihet Bladi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { 
      font-family: 'Segoe UI', sans-serif; 
      margin: 0; 
      background: #121111; 
      color: #333; 
    }

    /* === NAVIGATION === */
    .nav-yassir { 
      background: #fff; 
      border-bottom: 1px solid #e0e0e0; 
      box-shadow: 0 2px 8px rgba(0,0,0,0.05); 
      padding: 10px 30px; 
      display: flex; 
      justify-content: space-between; 
      align-items: center; 
      position: sticky; 
      top: 0; 
      z-index: 100; 
    }
    .logo-yassir { display:flex; align-items:center; gap:10px; font-size:20px; font-weight:bold; color:#0d47a1; }
    .logo-yassir img { width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid #0d47a1; }
    .nav-links { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
    .nav-links li a { text-decoration:none; color:#444; font-weight:500; padding:8px 14px; border-radius:10px; transition:.3s; }
    .nav-links li a:hover { background:#56CFCA; color:#fff; }

    /* === CONTAINER === */
    .container { 
      max-width: 1000px; 
      margin: 2em auto; 
      background: #fff; 
      padding: 2.5em; 
      border-radius: 16px; 
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    h2 { 
      color: #222; 
      text-align: center; 
      margin-bottom: 1.5em; 
      font-size: 1.8rem;
    }

    /* === FORMULAIRE + IMAGE EN 2 COLONNES === */
    .form-image-wrapper {
      display: flex;
      gap: 2em;
      align-items: stretch;
    }

    .form-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    form { display:flex; flex-direction:column; gap:1em; }

    input {
      padding: 0.9em;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s;
    }
    input:focus {
      border-color: #ff6600;
      box-shadow: 0 0 6px rgba(255,102,0,0.4);
      outline: none;
    }

    button {
      background: #ff6600;
      color: #fff;
      padding: 1em;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background .3s;
    }
    button:hover { background:#e65c00; }

    .message { 
      margin-top: 1em; 
      font-weight: bold; 
      padding: 0.9em; 
      border-radius: 8px; 
      text-align: center;
      animation: fadeIn 0.5s ease;
    }
    .success { background:#e6ffe6; color:green; border:1px solid #a5d6a7; }
    .error { background:#ffe6e6; color:red; border:1px solid #ef9a9a; }

    /* === IMAGE === */
    .form-image { flex: 1; display:flex; justify-content:center; align-items:center; }
    .form-image img { max-width:100%; border-radius:16px; box-shadow:0 6px 16px rgba(0,0,0,0.2); }

    /* === RESPONSIVE MOBILE === */
    @media (max-width: 768px) {
      .form-image-wrapper { flex-direction: column; }
      .form-image { margin-top: 1.5em; }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px);}
      to { opacity: 1; transform: translateY(0);}
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
      <li><a href="login.php">Login</a></li>
      <li><a href="partenaires.html">Partenaires</a></li>
    </ul>
  </div>
</header>

<div class="container">
  <h2>Formulaire d'inscription vendeur</h2>
  
  <div class="form-image-wrapper">
    <!-- Formulaire -->
    <div class="form-container">
      <form method="POST">
        <input type="text" name="nom" placeholder="Nom *" required>
        <input type="text" name="prenom" placeholder="Prénom *" required>
        <input type="email" name="email" placeholder="Email *" required>
        <input type="text" name="telephone" placeholder="Téléphone">
        <input type="text" name="ville" placeholder="Ville">
        <button type="submit">S'inscrire</button>
      </form>
      <?php if (!empty($message)) echo "<p class='message $message_type'>$message</p>"; ?>
    </div>

    <!-- Image -->
    <div class="form-image">
      <img src="images/8 15 2025 (1).png" alt="Transport">
    </div>
  </div>
</div>
</body>
</html>
