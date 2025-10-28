
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

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php"); // redirige vers la page de connexion
    exit;
}
// Récupération du nom d'utilisateur
$username = htmlspecialchars($_SESSION['username']);

// Connexion à la base de données
$host = 'localhost';
$dbname = 'inscription';
$dbuser = 'root';
$dbpass = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélection des clients (avec colonnes réelles dans ta table)
    $stmt = $pdo->prepare("SELECT nom, email FROM clients"); // ⚠ changer 'clients' et les champs selon ta BD
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération du nom d'utilisateur
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .card-infos {
    background: white;
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    padding: 25px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-infos:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.card-infos h5 {
    font-size: 1.3rem;
    color: #444;
    margin-bottom: 15px;
    font-weight: bold;
}

.card-infos ul.list-group {
    border: none;
}

.card-infos .list-group-item {
    border: none;
    padding: 12px 0;
    font-size: 1.05rem;
    background: transparent;
    border-bottom: 1px solid #f0f0f0;
}

.card-infos .list-group-item:last-child {
    border-bottom: none;
}

.card-infos strong {
    color: #6c63ff; /* Violet moderne */
}

        body {
            background: #f7f5fa;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background: linear-gradient(180deg, #f4b30eff, rgba(0, 0, 0, 1));
            color: white;
            min-height: 100vh;
            padding: 20px;
        }
        .sidebar h2 {
            font-weight: bold;
            margin-bottom: 30px;
         background:  #f4b30eff,

        }
        .sidebar a {
            display: block;
            padding: 10px 0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .main-content {
            padding: 20px;
        }
       .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-card h3 {
            color:  #f4b30eff,
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Rihit Bladi</h2>
        <p>Bonjour, <?php echo $username; ?> Bienvenue</p>

        <a href="profile.php"> Mon profil</a>
        <a href="commande.php"> Mes commandes</a>
        <a href="#">⚙ Paramètres</a>
        <a href="logout.php"> Déconnexion</a>
    </div>

    <!-- Main content -->
    <div class="main-content flex-grow-1">
        <h1 class="mb-4">Tableau de bord</h1>

        <!-- Statistiques -->
        <div class="row g-3">
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>15</h3>
                    <p>Commandes aujourd’hui</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>8</h3>
                    <p>Livraisons en cours</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>254</h3>
                    <p>Clients inscrits</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>5</h3>
                    <p>Messages non lus</p>
                </div>
            </div>
        </div>

        <!-- Zone infos -->
         <div class="card mt-4 p-4">
            <h3>Bienvenue dans votre espace personnel</h3>
            <p>Ici, vous pouvez gérer vos informations, consulter vos commandes et plus encore.</p>
            <?php if ($clients): ?>
            <hr>
            <h5>Vos informations</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>Nom :</strong> <?php echo htmlspecialchars($clients['nom']); ?></li>
                <li class="list-group-item"><strong>Email :</strong> <?php echo htmlspecialchars($clients['email']); ?></li>
                <li class="list-group-item"><strong>Téléphone :</strong> <?php echo htmlspecialchars($clients['telephone']); ?></li>
                <li class="list-group-item"><strong>Adresse :</strong> <?php echo htmlspecialchars($clients['adresse']); ?></li>
            </ul>
            <?php else: ?>
                <p class="text-danger">Impossible de récupérer vos informations.</p>
            <?php endif; ?>
        </div> <!--
    </div>
</div>
        </div>
    </div>
</div>

</body>
</html>
