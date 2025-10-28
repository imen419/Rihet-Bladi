

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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
    $ville = htmlspecialchars(trim($_POST['ville'] ?? ''));
    $email_raw = trim($_POST['email'] ?? '');
    $email = filter_var($email_raw, FILTER_VALIDATE_EMAIL);

    if (!$nom || !$prenom || !$email || !$ville) {
        $message = "<div class='error'>⚠️ Veuillez remplir tous les champs correctement.</div>";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=inscription;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE email = ?");
            $stmtCheck->execute([$email]);
            if ($stmtCheck->fetchColumn() > 0) {
                $message = "<div class='error'>⚠️ Cet email est déjà utilisé.</div>";
            } else {
                $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, email, ville) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $ville]);

                $message = "<div class='success'>✅ Inscription réussie pour <strong>" . htmlspecialchars("$prenom $nom") . "</strong>.</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='error'>❌ Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Business  Rihet Bladi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    
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
      z-index: 1000;
    }
    .logo-yassir {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 20px;
      font-weight: bold;
      color: #0d47a1;
      user-select: none;
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

/* ----------------- Reset & Base ----------------- */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body {
  background-color: #f5f5f5;
  color: #333;
  line-height: 1.6;
  min-height: 100vh;
  padding: 0;
}

/* ----------------- Header Navigation ----------------- */
.nav-yassir {
  background: #fff;
  border-bottom: 1px solid #e0e0e0;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  padding: 12px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 1000;
}



/* ----------------- Section Intro ----------------- */
.intro, .section-title {
  max-width: 750px;
  margin: 50px auto 30px auto;
  text-align: center;
}

.section-title {
  font-size: 2rem;
  font-weight: 700;
  color: #111;
  margin-bottom: 20px;
}

/* ----------------- Services Grid ----------------- */
.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 25px;
  max-width: 1100px;
  margin: 0 auto 50px auto;
}

.service-card {
  background: #fff;
  padding: 30px 25px;
  border-radius: 14px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.service-card h3 {
  font-size: 1.3rem;
  margin-bottom: 12px;
  color: #111;
}

.service-card p {
  font-size: 1rem;
  color: #555;
}

/* ----------------- Masonry Images ----------------- */
.masonry-images {
  column-count: 4;
  column-gap: 20px;
  margin: 50px auto;
  max-width: 1200px;
}

.masonry-images img {
  width: 100%;
  display: block;
  margin-bottom: 20px;
  border-radius: 12px;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.masonry-images img:hover {
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

/* ----------------- Business Section ----------------- */
.business {
  padding: 60px 20px;
  background-color: #fff;
}

.business-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  gap: 40px;
  flex-wrap: wrap;
}

.business-text {
  flex: 1 1 500px;
}

.business-title {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #111;
}

.business-desc {
  font-size: 1.1rem;
  margin-bottom: 30px;
  color: #555;
}

.business-buttons a {
  display: inline-block;
  padding: 12px 25px;
  margin-right: 15px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}

.btn-primary {
  background-color: #111;
  color: #fff;
}

.btn-primary:hover {
  background-color: #333;
}

.btn-secondary {
  background-color: #fff;
  color: #111;
  border: 2px solid #111;
}

.btn-secondary:hover {
  background-color: #111;
  color: #fff;
}

/* ----------------- Stats Section ----------------- */
.stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 30px;
  text-align: center;
  padding: 60px 20px;
  background-color: #f5f5f5;
  border-radius: 16px;
  margin: 50px auto;
  max-width: 1100px;
}

.stats .stat h2 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 10px;
  color: #111;
}

.stats .stat p {
  font-size: 1rem;
  color: #555;
}

/* ----------------- Footer ----------------- */
footer {
  text-align: center;
  padding: 25px 15px;
  background: #fff;
  font-size: 0.9rem;
  color: #555;
  margin-top: 80px;
  border-top: 1px solid #e0e0e0;
}

footer a {
  color: #111;
  text-decoration: none;
  margin: 0 8px;
}

footer a:hover {
  text-decoration: underline;
}

/* ----------------- Responsive ----------------- */
@media (max-width: 1200px) { .masonry-images { column-count: 3; } }
@media (max-width: 900px) { 
  .masonry-images { column-count: 2; } 
  .services-grid { grid-template-columns: 1fr; }
}
/* ----------------- Business Buttons Circulaires ----------------- */
.business-buttons a {
  display: inline-block;
  padding: 12px 40px;        /* ajuster pour la largeur du texte */
  border-radius: 9999px;     /* complètement circulaire */
  font-weight: 700;
  font-size: 1.1rem;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

/* Bouton principal noir / texte blanc */
.business-buttons .btn-primary {
  background-color: #111;
  color: #fff;
  border: none;
}

/* Hover bouton principal */
.business-buttons .btn-primary:hover {
  background-color: #333;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}

/* Bouton secondaire blanc / texte noir avec bordure noire */
.business-buttons .btn-secondary {
  background-color: #fff;
  color: #111;
  border: 2px solid #111;
        cursor: pointer;

}

/* Hover bouton secondaire */
.business-buttons .btn-secondary:hover {
  background-color: #111;
  color: #fff;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}

/* Responsive pour mobile */
@media (max-width: 600px) {
  .business-buttons a {
    width: 100%;
    text-align: center;
    margin-bottom: 10px;
  }
}

    


/* Image large qui prend 2 colonnes et 2 lignes */


/* Image très haute */


/* Image très large */

/* Image très grande (large + tall) */
/* Masonry Images Style Yassir */
.masonry-images {
  column-count: 4; /* nombre de colonnes */
  column-gap: 20px; /* espace entre colonnes */
  margin: 50px auto;
  max-width: 1200px;
}

.masonry-images img {
  width: 100%;
  display: block;
  margin-bottom: 20px;
  border-radius: 12px;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  cursor: pointer;
}

.masonry-images img:hover {
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width: 1200px) {
  .masonry-images {
    column-count: 3;
  }
}

@media (max-width: 900px) {
  .masonry-images {
    column-count: 2;
  }
}

@media (max-width: 600px) {
  .masonry-images {
    column-count: 1;
  }
}



    /* Devenons partenaires */
    .partners-section {
      max-width: 900px;
      margin: 50px auto;
      text-align: center;
    }
    .partners-section h2 {
      font-size: 1.7rem;
      color: #0d4745;
      margin-bottom: 20px;
      font-weight: 700;
    }
    .partners-list {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      font-weight: 700;
      font-size: 1.1rem;
      color: #444;
      user-select: none;
    }

    /* Inscription Vendeur */
    section.inscription-vendeur {
      max-width: 420px;
      margin: 70px auto 100px auto;
    }
    form.formulaire {
      background: white;
      padding: 30px 25px;
      border-radius: 14px;
      box-shadow: 0 8px 20px rgba(86,207,202,0.25);
    }
    form.formulaire h2 {
      text-align: center;
      color: #ff6f00;
      margin-bottom: 25px;
      font-weight: 700;
      user-select: none;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: 700;
      color: #0d4745;
      user-select: none;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px 12px;
      margin-top: 7px;
      border: 1.5px solid #ff6f00;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    input:focus {
      border-color: #ff6f00;
      outline: none;
      box-shadow: 0 0 8px #ff6f00;
    }
    .password-container {
      position: relative;
    }
    .toggle-pass-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 0.9rem;
      color: #555;
      user-select: none;
    }
    .checkbox-container {
      margin-top: 15px;
      font-size: 0.9rem;
      color: #444;
      user-select: none;
    }
    .checkbox-container a {
      color: #ff6f00;
      text-decoration: none;
    }
    .checkbox-container a:hover {
      text-decoration: underline;
    }
    .btn-group {
      margin-top: 25px;
      display: flex;
      justify-content: center;
    }
    .btn-group button {
      padding: 14px 30px;
      font-weight: 700;
      font-size: 1.1rem;
      border-radius: 30px;
      border: 2px solid #cfa956;
      background: white;
      color: #ff6f00;
      cursor: pointer;
      transition: background-color 0.3s ease;
      user-select: none;
    }
    .btn-group button:hover {
      background-color: #ff6f00;
      color: white;
    }
    .success, .error {
      text-align: center;
      margin-top: 20px;
      font-weight: 700;
      user-select: none;
    }
    .success { color: #28a745; }
    .error { color: #dc3545; }
.business {
  padding: 60px 20px;
  background-color: #f9f9f9;
}

.business-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  gap: 40px; /* espace entre texte et image */
  flex-wrap: wrap; /* pour que ça reste responsive */
}

.business-text {
  flex: 1 1 500px; /* prend l’espace disponible */
}

.business-title {
  font-size: 2rem;
  margin-bottom: 20px;
}

.business-desc {
  font-size: 1.1rem;
  margin-bottom: 30px;
}

.business-buttons a {
  display: inline-block;
  padding: 12px 25px;
  margin-right: 15px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
}

.btn-primary {
  background-color: #ff6600;
  color: #fff;
}

.btn-secondary {
  background-color: #fff;
  color: #ff6600;
  border: 2px solid #ff6600;
}

.business-image {
  flex: 1 1 400px;
  text-align: center;
}

.business-image img {
  max-width: 100%;
  height: auto;
  border-radius: 12px;
}

    /* Footer */
    footer {
      text-align: center;
      padding: 25px 15px;
      background: #f1f1f1;
      font-size: 0.9rem;
      color: #555;
      user-select: none;
      margin-top: 80px;
      border-top: 1px solid #ddd;
    }
    footer a {
      color: #56CFCA;
      text-decoration: none;
      margin: 0 8px;
      user-select: none;
    }
    footer a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .nav-yassir {
        flex-direction: column;
        gap: 12px;
      }
      .services-grid {
        grid-template-columns: 1fr;
      }
      .partners-list {
        flex-direction: column;
        gap: 15px;
      }
      .masonry-images {
        grid-template-columns: 1fr 1fr;
        grid-auto-rows: 120px;
      }
      section.inscription-vendeur {
        margin: 40px 15px 60px;
      }
    }
    .partners-delivery-section {
  max-width: 900px;
  margin: 60px auto;
  text-align: center;
  color: #0d4745;
  user-select: none;
}

.partners-delivery-section h2 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 20px;
}

.partners-list {
  display: flex;
  justify-content: center;
  gap: 30px;
  font-weight: 700;
  font-size: 1.2rem;
  color: #444;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.delivery-info {
  max-width: 600px;
  margin: 0 auto;
  text-align: left;
  font-size: 1.1rem;
  line-height: 1.6;
}

.delivery-info h3 {
  font-size: 1.6rem;
  margin-bottom: 15px;
  color: #ff6f00;
}

.delivery-info p {
  margin-bottom: 25px;
  color: #333;
}

.btn-group {
  text-align: center;
  margin-top: 30px;
}

.btn-devenir-livreur {
  background-color: #ff6f00;
  color: white;
  padding: 14px 35px;
  font-weight: 700;
  border-radius: 30px;
  text-decoration: none;
  transition: background-color 0.3s ease;
  user-select: none;
}

.btn-devenir-livreur:hover {
  background-color: #e65c00;
}

  </style>
</head>
<body>

  <!-- Header Navigation -->
  <header class="nav-yassir">
    <div class="logo-yassir">
      <img src="images/Logo rbt.png" alt="Logo Rihet Bladi" />
      <span>Rihet <strong>Bladi</strong></span>
    </div>
    <ul class="nav-links">
      <li><a href="index.html">Accueil</a></li>
              <li><a href="login.php">Connexion </a></li>
      <li><a href="business.php">Business</a></li>
      <li><a href="livraison.php">Livraison</a></li>
      <li><a href="Commande.php">Commande</a></li>
      <li><a href="partenaires.html">Partenaires</a></li>
    </ul>
  </header>
<!-- Section Rihet Bladi Platform (Image gauche / Texte droite) -->
<section class="rihet-section">
  <div class="rihet-image">
            <img src="images/map (2).png " alt="v">

  </div>
  <div class="rihet-content">
    <span class="rihet-tagline">نكهة تونسية بأيادٍ نسائية </span>
    <h2>Rihet Bladi</h2>
    <p>Votre plateforme tunisienne innovante pour commander, livrer et savourer des plats traditionnels en conserve. 
    Conçue pour vous offrir authenticité, rapidité et sécurité.</p>
    <a href="#" class="btn-rihet">Découvrir maintenant</a>
  </div>
</section>

<style>
.rihet-section {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  padding: 60px 10%;
  background: linear-gradient(to right, #0f0101ff, #0e0d0dff);
}

.rihet-image {
  flex: 1;
  text-align: center;
  animation: fadeInLeft 1s ease;
}

.rihet-image img {
  max-width: 380px;
  width: 100%;
}

.rihet-content {
  flex: 1;
  min-width: 280px;
  margin-left: 30px;
  animation: fadeInRight 1s ease;
}

.rihet-tagline {
  display: inline-block;
  font-size: 1em;
  color: rgba(211, 74, 24, 1)ff; /* Turquoise */
  margin-bottom: 10px;
  font-weight: bold;
}

.rihet-content h2 {
  font-size: 2.5em;
  color: #6d0a7aff; /* Orange */
  margin-bottom: 20px;
}

.rihet-content p {
  font-size: 1.2em;
  color: #333;
  margin-bottom: 25px;
  line-height: 1.6;
}

.btn-rihet-round {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 70px;   /* نفس القيمة للعرض والطول */
  height: 70px;
  background-color: #e16a16; /* برتقالي ريحت بلادي */
  color: #fff;
  font-size: 22px;  /* حجم النص أو الأيقونة */
  font-weight: bold;
  border: none;
  border-radius: 50%; /* يجعل الشكل دائري */
  cursor: pointer;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.btn-rihet-round:hover {
  background-color: #c95d12; /* برتقالي أغمق عند التمرير */
  transform: scale(1.1);
}


.btn-rihet:hover {
  background-color: #33b8b0;
}

/* Animation */
@keyframes fadeInLeft {
  from {opacity: 0; transform: translateX(-50px);}
  to {opacity: 1; transform: translateX(0);}
}

@keyframes fadeInRight {
  from {opacity: 0; transform: translateX(50px);}
  to {opacity: 1; transform: translateX(0);}
}

/* Responsive */
@media(max-width: 768px) {
  .rihet-section {
    flex-direction: column;
    text-align: center;
  }
  .rihet-content {
    margin-left: 0;
    margin-top: 20px;
  }
}
</style>

  <!-- Section "Tout vos besoins en une seule appli" -->
  <section class="intro">
    <h1 class="section-title">Tout vos besoins en une seule appli</h1>
    <div class="services-grid">
      <div class="service-card">
        <h3>Rihet Bladi Ride</h3>
        <p>Votre solution de transport simple et rapide.</p>
      </div>
      <div class="service-card">

        <h3>Rihet Bladi Food</h3>
        <p>Commandez vos plats préférés en quelques clics.</p>
      </div>
      <div class="service-card">
        <h3>Rihet Bladi Market</h3>
        <p>Faites vos courses depuis votre téléphone.</p>
      </div>
      <div class="service-card">
        <h3>Rihet Bladi Cash</h3>
        <p>Vos paiements en toute simplicité.</p>
      </div>
    </div>
    






<!-- Section Business -->
<section class="business">
  <div class="business-container">

    <!-- Colonne gauche (texte) -->
    <div class="business-text">
      <h2 class="business-title">Gérez vos déplacements professionnels et ceux de vos collaborateurs depuis une seule plateforme.</h2>
      <p class="business-desc">
        Une solution simple, ergonomique et efficace pour vos besoins professionnels.
      </p>

      <!-- Boutons -->
      <div class="business-buttons">
        <a href="#" class="btn-primary">Découvrir Rihet Bladi Business</a>
        <a href="#contact" class="btn-secondary">Nous contacter</a>
      </div>

      

    <!-- Colonne droite (image) -->
    <div class="business-image">
     <img src="images/RIHITBLED.png " alt="Lablabi">

    </div>

  </div>
</section>

    <h2 class="section-title">Services Rihet Bladi</h2>
    <div class="services-grid">
      <div class="service-card">
        <h3>Utilisez votre solde Rihet Bladi Cash</h3>
        <p>Payer vos trajets sur Rihet Bladi Go et les livraisons Yassir Express.</p>
      </div>
      <div class="service-card">
        <h3>Transactions</h3>
        <p>Envoyez de l'argent à vos proches facilement.</p>
      </div>
      <div class="service-card">
        <h3>Fluide & sécurisé</h3>
        <p>Profitez de transactions transparentes, sûres et rapides.</p>
      </div>
    </div>

    <h2 class="section-title">Nos valeurs</h2>
    <div class="services-grid">
      <div class="service-card">
        <h3>Ambition</h3>
        <p>L'ambition sans limite de notre équipe pour innover et grandir.</p>
      </div>
      <div class="service-card">
        <h3>Transparence et confiance</h3>
        <p>Une communication ouverte pour une collaboration sincère.</p>
      </div>
      <div class="service-card">
        <h3>Qualité</h3>
        <p>Des produits d'une qualité inégalée.</p>
      </div>
      <div class="service-card">
        <h3>Performance</h3>
        <p>Des services performants, repoussant les limites du possible.</p>
      </div>
    </div>

  </section>

  
  <!-- Devenons partenaires -->
<section class="partners-section">
  <!-- Masonry Images -->
  <div class="masonry-images" aria-label="Images illustratives style Yassir">
      <img src="images/chatjpt besnis.png" alt="Transport">
     <img src="images/besniss3.jpg" alt="Illustration partenaire 3" />
    <img src="images/besniss 4.jpg" alt="Illustration partenaire 4" />
    <img src="images/bisniss7.jpg" alt="Illustration partenaire 5" />
  </div>

  <!-- Texte Devenons partenaires -->
  <section class="partners-delivery-section">
    <h2>Devenons partenaires</h2>
    <div class="partners-list">
      <a href="Conduire.php">Conduire</a>
      <a href="Vendre.php">Vendre</a>
      <a href="livraison.php">Livrer</a>
       <a href="register.php">inscription</a>

    </div>
  </section>
</section>

  <!-- delivery-info-->

  <div class="delivery-info">
    <h3></h3>
    <p><strong></strong><br>
      
    <p><strong></strong><br>
      </p>

    <p><strong></strong><br>
      </p>

    <div class="btn-group">
      <a href="livraison.php" class="btn-devenir-livreur">Devenir livreur</a>
    </div>
  </div>
</section>
<!-- Section Statistiques -->
<section class="stats">
  <div class="stat">
    <h2>8M+</h2>
    <p>Téléchargements depuis 2017</p>
  </div>
  <div class="stat">
    <h2>100k+</h2>
    <p>Partenaires</p>
  </div>
  <div class="stat">
    <h2>4k+</h2>
    <p>Employés</p>
  </div>
  <div class="stat">
    <h2>45+</h2>
    <p>Villes où nous sommes présents</p>
  </div>
</section>


  <!-- Inscription vendeur -->
  <!-- <section class="inscription-vendeur">
    <form method="post" action="" class="formulaire" novalidate>
      <h2> Inscription</h2>

      <label for="nom">Nom :</label>
      <input type="text" name="nom" id="nom" required>

      <label for="prenom">Prénom :</label>
      <input type="text" name="prenom" id="prenom" required>

      

      <div class="checkbox-container">
        <input type="checkbox" id="cgu" required>
        <label for="cgu">J'accepte les <a href="#">conditions générales</a>.</label>
      </div>

      <div class="btn-group">
        <button type="submit">S'inscrire</button>
      </div>

      <?= $message ?>
    </form>
  </section>-->

  <footer>
    <p>&copy; 2025 Rihet Bladi - Tous droits réservés.</p>
    <p>
      <a href="#">Mentions légales</a> |
      <a href="#">Politique de confidentialité</a> |
      <a href="#">Nous contacter</a>
    </p>
  </footer>

  <script>
    const toggleBtn = document.getElementById('togglePassBtn');
    const passInput = document.getElementById('mot_de_passe');

    toggleBtn.addEventListener('click', () => {
      if (passInput.type === 'password') {
        passInput.type = 'text';
        toggleBtn.textContent = 'Cacher';
      } else {
        passInput.type = 'password';
        toggleBtn.textContent = 'Afficher';
      }
    });
  </script>
</body>
</html>
