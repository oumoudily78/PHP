<?php
// 1. Vérifie que le chemin vers config.php est correct selon l'emplacement du fichier
require_once 'config.php'; 

$message = "";
$id = null;

// On récupère l'ID (soit du formulaire en POST, soit de l'URL en GET)
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
}

// Si aucun ID, on stoppe pour éviter l'erreur SQL
if (!$id) {
    die("Erreur : ID du produit voile manquant.");
}

// ==========================================
// TRAITEMENT DU FORMULAIRE (QUAND ON CLIQUE SUR ENREGISTRER)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $prix = isset($_POST['prix']) ? $_POST['prix'] : 0;
    $quantite = isset($_POST['quantite']) ? $_POST['quantite'] : 0;

    if (!empty($nom)) {
        try {
            $sql_update = "UPDATE produits 
                           SET nom = :nom, description = :description, prix = :prix, quantite = :quantite 
                           WHERE id = :id";
            
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                'nom' => $nom,
                'description' => $description,
                'prix' => $prix,
                'quantite' => $quantite,
                'id' => $id
            ]);

            // ATTENTION ICI : On redirige bien vers la page des voiles !
            header("Location: voile2.php?success=update");
            exit();

        } catch (Exception $e) {
            $message = "<p style='color: red;'>Erreur SQL : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>Le nom du produit est obligatoire.</p>";
    }
}

// ==========================================
// CHARGEMENT DES INFOS DANS LES INPUTS (AFFICHAGE)
// ==========================================
try {
    $sql = "SELECT p.*, c.label as nom_categorie 
            FROM produits p 
            JOIN categories c ON p.categorie_id = c.id 
            WHERE p.id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $produit = $stmt->fetch();

    if (!$produit) {
        die("Erreur : Ce produit n'existe pas.");
    }
} catch (Exception $e) {
    die("Erreur SQL : " . $e->getMessage());
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
    
    <form action="Mettre_à_jour_voile.php" method="POST">
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
            <button class="bouton_ok">
                <a href="voile2.php">Annuler</a>
            </button>
        </div>
    </form>
</div>

</body>
</html>