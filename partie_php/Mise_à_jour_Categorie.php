<?php
require_once 'config.php';

$categorie = null; // On initialise à vide

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $categorie = $stmt->fetch();
}

// Si on n'a rien trouvé, on arrête tout avec un message propre
if (!$categorie) {
    die("<h3>Erreur : Aucune catégorie sélectionnée ou ID invalide.</h3><a href='../Administration.html'>Retour</a>");
}

// ... reste du code (Traitement POST)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mise à jour Catégorie</title>
    <link rel="stylesheet" href="../Ajout_mise_a_jour/Sytle3.css">
</head>
<body>
    <h3>Mise à jour catégorie</h3>
    
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $categorie['id'] ?>">

        <label>Code (ID):</label>
        <input type="text" value="<?= $categorie['id'] ?>" disabled><br><br>

        <label for="label">Nouveau Label:</label>
        <input type="text" name="label" value="<?= htmlspecialchars($categorie['label']) ?>" required><br><br>

        <button type="submit">Mise à jour</button>
    </form>
</body>
</html>