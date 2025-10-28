
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
// chatbot.php

if(isset($_POST['message'])){
    $msg = strtolower(trim($_POST['message']));

    // Réponses dynamiques avec regex
    $responses = [
        "/\b(rihet bladi)\b/" => "🌍 Rihet Bladi est votre application tunisienne pour livraison, transport et services.",
        "/\b(transport|taxi|ride|trajet)\b/" => "🚖 Nous offrons le service <b>Rihet Bladi Ride</b> pour vos trajets rapides et sécurisés.",
        "/\b(food|nourriture|plat|restaurant)\b/" => "🍲 Commandez vos plats préférés via <b>Rihet Bladi Food</b>.",
        "/\b(market|courses|shop|épicerie)\b/" => "🛒 Faites vos courses depuis votre téléphone avec <b>Rihet Bladi Market</b>.",
        "/\b(cash|paiement|argent|payer)\b/" => "💳 <b>Rihet Bladi Cash</b> permet de gérer vos paiements facilement.",

        // Nouveaux ajouts
        "/\b(comment ça va|ça va|كيف حالك)\b/" => "😊 Je vais très bien, merci ! Et vous ?",
        "/\b(bonjour|cvsalut|صباح الخير)\b/" => "🌞 Bonjour ! Toute l’équipe Rihet Bladi vous souhaite une excellente journée.",
        "/\b(horaire|temps|heures|travail|أوقات العمل|متى تعملون)\b/" => "🕒 Nos services sont disponibles 7j/7, de <b>8h00 à 22h00</b>.",
        "/\b(plat|plats|menu|dishes|وجبات|أطباق|أكلات)\b/" => "🍽️ Voici quelques plats disponibles sur <b>Rihet Bladi Food</b> : Couscous, Tajine, Lablabi, Ojja merguez, Brik, Kafteji et bien plus encore 😋.",
        "/\b(merci|شكرا|thanks|thank you)\b/" => "🙏 Avec plaisir ! L’équipe Rihet Bladi est toujours là pour vous."
    ];

    foreach($responses as $pattern=>$reply){
        if(preg_match($pattern,$msg)){
            echo $reply;
            exit;
        }
    }

        // Réponse par défaut
    echo "🙏 Désolé, je n’ai pas compris. Pouvez-vous reformuler ?";
    exit;
}  // <---- هذي كانت ناقصة
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chat Rihet Bladi</title>
<style>
body {
    margin:0; padding:0; font-family: Arial,sans-serif; background:#0d1117; display:flex; justify-content:center; align-items:center; height:100vh;
}
.chat-container { width: 400px; max-height: 80vh; background:#161b22; border-radius:12px; display:flex; flex-direction:column; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.3);}
.chat-header { padding:15px; background:#21262d; color:#fff; font-weight:bold; text-align:center; border-bottom:1px solid #30363d;}
.chat-box { flex:1; padding:15px; overflow-y:auto; background:#161b22;}
.chat-box p { margin:10px 0; line-height:1.4; padding:10px 15px; border-radius:12px; max-width:80%; word-wrap:break-word;}
.user { background:#ff6f00; color:#fff; margin-left:auto; text-align:right;}
.bot { background:#21262d; color:#c9d1d9; margin-right:auto; text-align:left;}
.chat-form { display:flex; border-top:1px solid #30363d; background:#0d1117;}
.chat-form input { flex:1; padding:12px 15px; border:none; background:#161b22; color:#fff; font-size:1rem;}
.chat-form input:focus { outline:none;}
.chat-form button { padding:0 20px; background:#ff6f00; border:none; cursor:pointer; color:#fff; font-weight:bold; transition:0.3s;}
.chat-form button:hover { background:#e65c00;}
</style>
</head>
<body>
</style>
</head>
<body>

<div class="chat-container">
  <div class="chat-header">Chat Rihet Bladi</div>
  <div class="chat-box" id="chat-box"></div>
  <form id="chat-form" class="chat-form">
    <input type="text" id="user-message" placeholder="Posez votre question..." required>
    <button type="submit">Envoyer</button>
  </form>
</div>

<script>
const form = document.getElementById('chat-form');
const chatBox = document.getElementById('chat-box');

form.addEventListener('submit', function(e){
    e.preventDefault();
    const message = document.getElementById('user-message').value.trim();
    if(message==='') return;

    const userPara = document.createElement('p');
    userPara.className='user';
    userPara.textContent=message;
    chatBox.appendChild(userPara);

    document.getElementById('user-message').value='';
    chatBox.scrollTop=chatBox.scrollHeight;

    const xhr = new XMLHttpRequest();
    xhr.open('POST','chatbot.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload=function(){
        const botPara=document.createElement('p');
        botPara.className='bot';
        botPara.textContent=this.responseText;
        chatBox.appendChild(botPara);
        chatBox.scrollTop=chatBox.scrollHeight;
    };
    xhr.send('message='+encodeURIComponent(message));
});
</script>

</body>
</html>
