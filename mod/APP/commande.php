

<?php


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

// Initialisation message de retour
$messageRetour = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $nom      = isset($_POST['nom']) ? htmlspecialchars(trim($_POST['nom'])) : '';
    $email    = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : false;
    $plat     = isset($_POST['plat']) ? htmlspecialchars(trim($_POST['plat'])) : '';
    $quantite = isset($_POST['quantite']) ? floatval($_POST['quantite']) : 0;
    $adresse  = isset($_POST['adresse']) ? htmlspecialchars(trim($_POST['adresse'])) : '';

    // Validation des champs obligatoires
    if (!$nom || !$email || !$plat || $quantite <= 0 || !$adresse) {
        $messageRetour = "<p style='color:red;'>Veuillez remplir tous les champs correctement.</p>";
    } else {
        // Calcul prix (exemple 10 DT par kg)
        $prix = 10 * $quantite;

        // Préparation et exécution de la requête
        $stmt = $pdo->prepare("INSERT INTO commandes (nom, adresse, plat, quantite, email, prix) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $adresse, $plat, $quantite, $email, $prix]);

        // Envoi email de confirmation
        $subject = "Confirmation de votre commande Rihet Bladi";
        $body    = "Bonjour $nom,\n\nMerci pour votre commande : $quantite kg de $plat.\nAdresse : $adresse\nTotal à payer : $prix TND\n\nNous vous contacterons bientôt.\n\n— Équipe Rihet Bladi";
        $headers = "From: no-reply@rihetbladi.tn";

        mail($to, $subject, $body, $headers);

        $messageRetour = "<p style='color:green;'>✅ Commande enregistrée avec succès. Un email de confirmation a été envoyé à $email.</p>";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Commandes - Rihet Bladi</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }


.btn-livraison {
  display: inline-block;
  background-color: #ff6f00;
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  transition: background-color 0.3s;
  cursor: pointer;
}
<header>

.btn-livraison:hover {
  background-color: #e65c00;
}

.btn-livraison {
  display: inline-block;
  background-color: #ff6f00;
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  transition: background-color 0.3s;
  cursor: pointer;
}

.btn-livraison:hover {
  background-color: #e65c00;
}


/* Style pour la boîte du chatbot */
#chatbot {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 300px;
  background: #ffffff;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  padding: 15px;
  font-family: Arial, sans-serif;
  border: 2px solid #56CFCA; /* turquoise */
  animation: fadeIn 0.4s ease-in-out;
  z-index: 1000;
}

/* Animation d'apparition */
@keyframes fadeIn {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

/* Titre */
#chatbot h3 {
  margin: 0;
  font-size: 16px;
  color: #6b2f8f; /* violet */
  display: flex;
  align-items: center;
  gap: 5px;
}

/* Texte */
#chatbot p {
  font-size: 14px;
  margin-top: 8px;
  color: #333;
}

/* Bouton de fermeture */
#close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #ff7a18; /* orange */
  border: none;
  color: white;
  font-size: 14px;
  border-radius: 50%;
  width: 25px;
  height: 25px;
  cursor: pointer;
  transition: 0.2s;
}

#close-btn:hover {
  background: #e56a0d;
  transform: scale(1.1);
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
.commande-section {
  display: flex;               /* تفعيل flexbox */
  flex-direction: row;         /* ترتيب أفقي: صورة + فورم */
  align-items: center;         /* محاذاة عمودية وسط */
  justify-content: space-between;
  gap: 40px;                  /* مسافة بين الصورة والفورم */
  max-width: 1000px;
  margin: 30px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.commande-image {
  flex: 1 1 300px;           /* صورة تأخذ مساحة مناسبة */
  text-align: left;
}

.commande-image img {
  max-width: 100%;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.commande-form {
  flex: 1 1 400px;           /* الفورم يأخذ المساحة الباقية */
  min-width: 280px;
}

.commande-form label,
.commande-form input,
.commande-form select,
.commande-form button {
  display: block;
  width: 100%;
  margin-top: 10px;
  font-size: 1rem;
}

.commande-form input,
.commande-form select {
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.commande-form button {
  margin-top: 20px;
  padding: 12px 20px;
  background-color: orange;
  border: none;
  border-radius: 30px;
  font-weight: 700;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.commande-form button:hover {
  background-color: #f57c00;
  color: #fff;
}

/* Responsive: ترتيب عمودي على الشاشات الصغيرة */
@media (max-width: 768px) {
  .commande-section {
    flex-direction: column;
    text-align: center;
  }
  .commande-image {
    margin-bottom: 20px;
    text-align: center;
  }
  .commande-form {
    min-width: auto;
  }
}

    form select,
    form input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    /* Titre agrandi */
    h2 {
      font-size: 2.5rem; /* titre plus grand */
      margin-bottom: 20px;
      color: #333;
    }

    /* Boutons petits et ronds */
    form button, .btn, .btn-pay {
      padding: 8px 20px;        /* moins haut, plus large */
      border-radius: 30px;      /* coins très arrondis */
      font-size: 0.9rem;        /* un peu plus petit */
      font-weight: 700;
      background-color: orange;
      color: #000;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
      text-align: center;
      text-decoration: none;
      display: inline-block;
    }

    form button:hover, .btn:hover, .btn-pay:hover {
      background-color: #f57c00;
      color: #fff;
    }

    .commande-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 20px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: transform 0.3s ease;
    }

    .commande-card:hover {
      transform: scale(1.02);
    }

    .commande-info {
      display: flex;
      flex-direction: column;
    }

    .commande-info span {
      margin-bottom: 6px;
      color: #333;
    }

    .commande-date {
      color: #999;
      font-size: 0.9rem;
    }
.btn-livraison {
  display: inline-block;
  padding: 8px 20px;          /* moins haut, plus large */
  border-radius: 30px;        /* coins très arrondis */
  font-size: 0.9rem;          /* un peu plus petit */
  font-weight: 700;
  background-color: orange;   /* fond orange vif */
  color: #000;                /* texte noir */
  border: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-livraison:hover {
  background-color: #f57c00;  /* orange un peu plus foncé au survol */
  color: #fff;                /* texte blanc au survol */
}

    .badge {
      background-color: orange;
      color: #000;
      font-weight: bold;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
    }
.commande-image {
  flex: 1 1 300px;
  text-align: center;
}

.commande-image img {
  max-width: 100%;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Responsive pour mobile */
@media (max-width: 768px) {
  .commande-section {
    flex-direction: column;
    text-align: center;
  }
}
    .btn {
      margin-top: 25px;
      border-radius: 30px; /* coins arrondis */
    }

    .redirect-box {
      margin-top: 40px;
      background-color: #fff9ed;
      padding: 20px;
      border-left: 6px solid orange;
      border-radius: 10px;
      text-align: center;
    }

    .redirect-box a {
      margin: 10px;
      display: inline-block;
      padding: 8px 18px; /* un peu plus petit */
      background-color: orange;
      color: #000;
      font-weight: bold;
      border-radius: 30px; /* coins arrondis */
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .redirect-box a:hover {
      background-color: rgb(15, 14, 14);
      color: #fff;
    }

    /* --- CARROUSEL --- */
    .carousel-container {
      background-color: #000;
      padding: 30px 0;
      overflow: hidden;
      margin-top: 60px;
    }

    .carousel-track {
      display: flex;
      width: fit-content;
      animation: scroll 30s linear infinite;
      gap: 30px;
    }

    .carousel-container img {
      height: 160px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(255, 165, 0, 0.4);
      transition: transform 0.3s ease;
    }

    .carousel-container img:hover {
      transform: scale(1.05);
    }

    @keyframes scroll {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }

    footer {
      display: flex;
      align-items: center;
      justify-content: start;
      background: linear-gradient(to right, #ff6f00, #ffb74d);
      color: white;
      padding: 20px 30px;
      flex-wrap: wrap;
      gap: 20px;
    }

    /* PARTENAIRE - IMAGE + FORM */
    .partner-section {
      display: flex;
      align-items: center;
      gap: 30px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }

    .partner-image {
      flex: 1 1 300px;
      text-align: center;
    }

    .partner-image img {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .partner-section form {
      flex: 1 1 300px;
      min-width: 280px;
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
      <li><a href="business.php">Business</a></li>
      <li><a href="livraison.php">Livraison</a></li>
      <li><a href="commande.php">Commande</a></li>
      <li><a href="partenaires.html">Partenaires</a></li>
    </ul>
  </div>
</header>

<!-- CONTENU PRINCIPAL -->
<?php
// Affichage du message retour
if ($messageRetour) {
    echo $messageRetour;
}
?>
<div class="commande-section">
  <div class="commande-image">
            <img src="images/RIHITBLED.png " alt="Lablabi">

  </div>

  <form method="post" action="" class="commande-form">
    <!-- حقول الفورم هنا -->
    <h2>Passer une commande</h2>

    <label for="nom">Nom complet :</label>
    <input type="text" id="nom" name="nom" required placeholder="Votre nom" />

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required placeholder="Votre email" />
    <label for="nom">adresse :</label>
    <input type="text" id="nom" name="adresse" required placeholder="Votre adresse" />


    <label for="plat">Plat :</label>
    <select id="plat" name="plat" required>
      <option value="">-- Choisissez --</option>
      <option value="Couscous">Couscous</option>
      <option value="Mloukhia">Mloukhia</option>
      <option value="Ojja">Ojja</option>
      <option value="Tajine">Tajine</option>
    </select>

    <label for="quantite">Quantité (kg) :</label>
    <select id="quantite" name="quantite" required>
      <option value="0.5">0.5</option>
      <option value="1">1</option>
      <option value="1.5">1.5</option>
      <option value="2">2</option>
      <option value="3">3</option>
    </select>

    <button type="submit">Valider</button>
  </form>
</div>

 
  <!-- Section partenaire avec image + formulaire -->
  <div class="partner-section">
    <div class="partner-image">
     <img src="images/imentravell.jfif" alt alt="Devenir partenaire Rihet Bladi" />
    </div>

    <form method="post" action="traitement_partenaire.php">
      <h2>Devenir partenaire</h2>

      <label for="type">Type de partenaire :</label>
      <select id="type" name="type" required>
        <option value="">-- Sélectionnez un type --</option>
        <option value="conduire">Conduire</option>
        <option value="vendre">Vendre</option>
        <option value="livrer">Livrer</option>
      </select>
<a href="commande.php" class="btn-livraison">Accéder à la livraison</a>

    </form>
  </div>

  <div class="redirect-box">
    <a href="commande.php">Accéder à la livraison</a>
    <a href="payer-en-ligne.php" class="btn-pay">💳 Payer en ligne</a>
  </div>
</div>
<div id="chatbot">
  <button id="close-btn" onclick="document.getElementById('chatbot').style.display='none'">
    ❌  
  </button>
  <h3> 👧 Rihet Bladi  </h3>
  <p> Bonjour 👋 ! Votre commande est bien reçue et sera livrée sous 48h</p>
</div>
<button onclick="document.getElementById('chatbot').style.display='none'">
</button>

<!-- CARROUSEL D'IMAGES -->
<div class="carousel-container">
  <div class="carousel-track">
    <img src="images/tayara.jfif" alt="Couscous">
    <img src="images/admini.jfif" alt="Ojja">
        <img src="images/7.png" alt="Couscous">

    <img src="images/liv 5.jfif" alt="Ojja">
    <img src="images/app.jfif" alt="Lablabi">
    <img src="images/4.png" alt="Couscous">
    <img src="images/imentravell.jfif" alt="Ojja">
    <img src="images/livreur 5.jfif" alt="Ojja">
    <img src="images/liv 5.jfif" alt="Ojja">
    <img src="images/sidi bou s3id.jfif" alt="Ojja">
     <img src="images/5.png" alt="Couscous">

  </div>
</div>

<footer>
  &copy; 2025 Rihet Bladi - Application de plats tunisiens en conserve 🇹🇳
</footer>

</body>
</html>



