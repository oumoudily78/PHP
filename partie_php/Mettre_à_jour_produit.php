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
    <title>Modifier le produit</title>
    <link rel="stylesheet" href="../Ajout_mise_a_jour/Sytle3.css"> 
</head>
<body>

<div class="block">
    <h3>Modifier le produit</h3>
    
    <form action="traiter_update.php" method="POST">
        <input type="hidden" name="id" value="<?= $produit['id'] ?>">

        <div class="form-group">
            <label>Nom du produit :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required>
        </div>

        <div class="form-group">
            <label>Description :</label>
            <textarea name="description" rows="5"><?= htmlspecialchars($produit['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Prix (FCFA) :</label>
            <input type="number" name="prix" value="<?= htmlspecialchars($produit['prix']) ?>" required>
        </div>

        <div class="form-group">
            <label>Quantité :</label>
            <input type="number" name="quantite" value="<?= htmlspecialchars($produit['quantite']) ?>" required>
        </div>

        <div class="form-group">
            <button type="submit">Enregistrer les modifications</button>
            <button type="button" class="btn-annuler">
                <a href="javascript:history.back()" style="text-decoration:none; color:white;">Annuler</a>
            </button>
        </div>
    </form>
</div>

</body>
</html>