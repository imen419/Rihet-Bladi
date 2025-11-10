<?php

class Membre {
    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $pdo;

    public function __construct($host, $dbname, $user, $pass) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function Afficher_Accordeon() {
        $sql = "SELECT id, nom_client, adresse, plat, quantite FROM commandes ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($commandes) === 0) {
            echo "<p>Aucune commande trouvée.</p>";
            return;
        }

        echo '<div class="accordeon">';
        foreach ($commandes as $commande) {
            echo '<div class="item">';
            echo '<div class="titre">Commande de ' . htmlspecialchars($commande['nom_client']) . '</div>';
            echo '<div class="contenu">';
            echo '<p><strong>Adresse :</strong> ' . htmlspecialchars($commande['adresse']) . '</p>';
            echo '<p><strong>Plat :</strong> ' . htmlspecialchars($commande['plat']) . '</p>';
            echo '<p><strong>Quantité :</strong> ' . htmlspecialchars($commande['quantite']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}
