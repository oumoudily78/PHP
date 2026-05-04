<?php
require_once 'config.php';

// On récupère l'ID envoyé par l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // On récupère les infos du produit et le nom de sa catégorie
        $sql = "SELECT p.*, c.label as nom_categorie 
                FROM produits p 
                JOIN categories c ON p.categorie_id = c.id 
                WHERE p.id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $produit = $stmt->fetch();

        if (!$produit) {
            die("Erreur : Produit introuvable.");
        }
    } catch (Exception $e) {
        die("Erreur SQL : " . $e->getMessage());
    }
} else {
    die("ID manquant.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="../style2.css">
</head>
<body>
    <div class="detail-box">
        <header class="head">
            <h2>Détails du Produit</h2>
        </header>

        <div class="fiche-details">
            <p><strong>ID :</strong> <?= htmlspecialchars($produit['id']) ?></p>
            <p><strong>Nom :</strong> <?= htmlspecialchars($produit['nom']) ?></p>
            <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($produit['description'])) ?></p>
            <p><strong>Prix :</strong> <?= htmlspecialchars($produit['prix']) ?> FCFA</p>
            <p><strong>Catégorie :</strong> <?= htmlspecialchars($produit['nom_categorie']) ?></p>
            
            <br>
            <button class="bouton_ok">
                <a href="javascript:history.back()" style="text-decoration:none; color:inherit;">Retour</a>
            </button>
        </div>
    </div>
</body>
</html>