
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

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id  = (int) $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');

// Connexion DB
$host = 'localhost';
$dbname = 'inscription';
$dbuser = 'root';
$dbpass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Recherche utilisateur: users d'abord
    $tables = ['users', 'clients', 'vendeurs', 'chauffeurs'];
    $clients = null;
    $user_type = '';
    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$user_id]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($clients) {
            $user_type = $table;
            break;
        }
    }

    if (!$clients) die("Aucun utilisateur trouvé pour cet ID.");

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Labels pour champs connus
$labels = [
    'id'=>'ID','nom'=>'Nom','prenom'=>'Prénom','email'=>'Email','telephone'=>'Téléphone',
    'adresse'=>'Adresse','ville'=>'Ville','code_postal'=>'Code postal','pays'=>'Pays',
    'date_naissance'=>'Date de naissance','sexe'=>'Sexe','cin'=>'CIN','created_at'=>"Date d'inscription",
    'updated_at'=>'Dernière mise à jour'
];

// Vérifie si photo existe
$photoFields = ['photo','avatar','photo_url','avatar_url'];
$photoUrl = null;
foreach($photoFields as $f){
    if(isset($clients[$f]) && !empty($clients[$f])){
        $photoUrl = $clients[$f];
        break;
    }
}

function safe($v){ return htmlspecialchars((string)$v, ENT_QUOTES,'UTF-8'); }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil <?= safe($user_type) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#000; color:#fff; font-family:Arial,sans-serif;}
.card{ border-radius:16px; box-shadow:0 6px 20px rgba(255,255,255,0.05); background:#1a1a1a;}
.avatar{ width:120px; height:120px; border-radius:50%; object-fit:cover; background:#333; display:block; margin:auto;}
.badge-label{ background:#ff6600; color:#fff;}
.btn-orange{ background:#ff6600; color:#fff;}
.btn-orange:hover{ background:#e65c00;}
.list-group-item{ border:none; border-bottom:1px solid #333; background:#1a1a1a; color:#fff;}
.list-group-item:last-child{ border-bottom:none;}
a{color:#ff6600; text-decoration:none;}
a:hover{color:#e65c00;}
</style>
</head>
<body>

<div class="container py-4">
    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-light border">← Retour au tableau de bord</a>
    </div>
    <div class="row g-4">
        <!-- Carte identité -->
        <div class="col-lg-4">
            <div class="card p-4 text-center">
                <h4 class="mb-3">Profil <?= ucfirst($user_type) ?></h4>
                <?php if($photoUrl): ?>
                    <img src="<?= safe($photoUrl) ?>" class="avatar mb-3" alt="Avatar">
                <?php else: ?>
                    <div class="avatar mb-3 d-flex align-items-center justify-content-center" style="font-size:36px; color:#ff6600;">
                        <?= strtoupper(substr(($clients['prenom']??$clients['nom']??$username),0,1)) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-2">
                    <span class="badge badge-label rounded-pill px-3 py-2">
                        <?= safe(($clients['prenom']??'').' '.($clients['nom']??'')) ?>
                    </span>
                </div>
                <div class="text-muted"><?= safe($clients['email']??'') ?></div>

                <div class="d-grid gap-2 mt-4">
                    <a href="edit_profile.php" class="btn btn-orange">Modifier le profil</a>
                    <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
            </div>
        </div>

        <!-- Carte détails -->
        <div class="col-lg-8">
            <div class="card p-4">
                <h5 class="mb-3">Toutes les informations</h5>
                <ul class="list-group">
                    <?php
                    foreach($labels as $key=>$label){
                        if(isset($clients[$key]) && $clients[$key]!==''){
                            echo '<li class="list-group-item d-flex justify-content-between">';
                            echo '<strong>'.safe($label).' :</strong>';
                            echo '<span>'.safe($client[$key]).'</span>';
                            echo '</li>';
                        }
                    }
                    foreach($clients as $key=>$val){
                        if(array_key_exists($key,$labels)) continue;
                        if($val==='') continue;
                        echo '<li class="list-group-item d-flex justify-content-between">';
                        echo '<strong>'.safe(ucwords(str_replace('_',' ',$key))).' :</strong>';
                        echo '<span>'.safe($val).'</span>';
                        echo '</li>';
                    }
                    ?>
                </ul>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="commande.php" class="btn btn-light border">Voir ses commandes</a>
                    <a href="contact_client.php?id=<?= (int)$clients['id'] ?>" class="btn btn-light border">Contacter</a>
                    <a href="delete_client.php?id=<?= (int)$clients['id'] ?>" class="btn btn-outline-danger"
                       onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
