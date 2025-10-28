
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

// تأكيد تسجيل الدخول
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id  = (int) $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');

// إعدادات قاعدة البيانات
$host = 'localhost';
$dbname = 'inscription';
$dbuser = 'root';
$dbpass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // جلب بيانات الحريف
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$user_id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$client) {
        die("Aucun client trouvé.");
    }

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// معالجة الفورم عند الإرسال
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom      = trim($_POST['nom'] ?? '');
    $prenom   = trim($_POST['prenom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $adresse  = trim($_POST['adresse'] ?? '');

    // تحقق بسيط
    if ($nom === '' || $prenom === '' || $email === '') {
        $error = "Nom, prénom et email sont obligatoires.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE clients SET nom=?, prenom=?, email=?, telephone=?, adresse=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $user_id]);
            $success = "Profil mis à jour avec succès!";
            // تحديث البيانات المحلية لعرضها فورًا
            $client['nom'] = $nom;
            $client['prenom'] = $prenom;
            $client['email'] = $email;
            $client['telephone'] = $telephone;
            $client['adresse'] = $adresse;
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

// دالة تنظيف البيانات
function safe($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#f7f5fa; }
        .card{ border-radius:16px; box-shadow:0 6px 20px rgba(0,0,0,0.05); max-width:600px; margin:auto; margin-top:40px; }
        .btn-orange{ background:#de8b10; color:#fff; }
        .btn-orange:hover{ background:#c97b0f; color:#fff; }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h3 class="mb-4 text-center">Modifier votre profil</h3>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= safe($success) ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= safe($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= safe($client['nom'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= safe($client['prenom'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= safe($client['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="<?= safe($client['telephone'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" value="<?= safe($client['adresse'] ?? '') ?>">
            </div>

            <div class="d-flex justify-content-between">
                <a href="profile.php" class="btn btn-light border">← Retour au profil</a>
                <button type="submit" class="btn btn-orange">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
