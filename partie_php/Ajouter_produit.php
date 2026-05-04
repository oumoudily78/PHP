<?php
require_once 'config.php';

$message = "";

// --- 1. CHARGER LES CATÉGORIES (pour la liste déroulante) ---
try {
    $stmtCat = $pdo->query("SELECT * FROM categories");
    $categories = $stmtCat->fetchAll();
} catch (Exception $e) {
    $categories = [];
}

// --- 2. TRAITEMENT DE L'ENREGISTREMENT ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nom'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie_id']; // Récupère l'ID choisi dans la liste

    try {
        $sql = "INSERT INTO produits (nom, description, quantite, prix, categorie_id) 
                VALUES (:nom, :description, :quantite, :prix, :categorie_id )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'description' => $description,
            'quantite' => $quantite,
            'prix' => $prix,
            'categorie_id' => $categorie_id
        ]);
        
        $message = "<p style='color:green; font-weight:bold;'>✅ Produit '$nom' ajouté avec succès !</p>";
    } catch (Exception $e) {
        $message = "<p style='color:red;'>❌ Erreur : " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="../Ajout_mise_a_jour/Sytle3.css">
</head>
<body>
    <div class="block">
        <h2>Ajouter un nouveau produit</h2>
        
        <form action="Ajouter_produit.php" method="POST">
            <label>Nom :</label>
            <input type="text" name="nom" required>

            <label>Description :</label>
            <textarea name="description"></textarea>

            <label>Quantité :</label>
            <input type="number" name="quantite" required>

            <label>Prix :</label>
            <input type="number" name="prix" step="0.01" required>

            <label>Catégorie :</label>
            <select name="categorie_id" required>
                <option value="">-- Choisir une catégorie --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['label'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name ="valider" class="bouton_ajouter">Enregistrer le produit</button>
            <a href="../produits_pc.php">Annuler</a>
        </form>
    </div>
</body>
</html>