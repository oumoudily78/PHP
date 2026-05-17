<?php
require_once 'config.php';

$message = "";
$id = null;

// 1. On récupère l'ID (soit du formulaire en POST, soit de l'URL en GET)
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
}

// Si aucun ID n'est trouvé, on arrête proprement
if (!$id) {
    die("<h3>Erreur : Aucune catégorie sélectionnée ou ID invalide.</h3><a href='../administration.php'>Retour</a>");
}

// ==========================================
// ÉTAPE A : TRAITEMENT DE LA MISE À JOUR (POST)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = isset($_POST['code']) ? trim($_POST['code']) : '';
    $label = isset($_POST['label']) ? trim($_POST['label']) : '';

    if (!empty($code) && !empty($label)) {
        try {
            // La requête pour mettre à jour le code et le label de la catégorie
            $sql_update = "UPDATE categories SET code = :code, label = :label WHERE id = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                'code' => $code,
                'label' => $label,
                'id' => $id
            ]);

            // Redirection vers la page d'administration après le succès
            header("Location: ../administration.php?success=cat_updated");
            exit();

        } catch (Exception $e) {
            $message = "<p style='color: red;'>Erreur lors de la mise à jour : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>Tous les champs sont obligatoires.</p>";
    }
}

// ==========================================
// ÉTAPE B : CHARGEMENT DES INFOS POUR L'AFFICHAGE (GET)
// ==========================================
try {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $categorie = $stmt->fetch();

    if (!$categorie) {
        die("<h3>Erreur : Catégorie introuvable en base de données.</h3><a href='../administration.php'>Retour</a>");
    }
} catch (Exception $e) {
    die("Erreur SQL : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mise à jour Catégorie</title>
    <link rel="stylesheet" href="../Ajout_mise_a_jour/Sytle3.css?v=1">
</head>
<body>
<div class="block">
    <h3>Mise à jour catégorie</h3>
    
    <?= $message ?>
    
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($categorie['id']) ?>">

        <div class="form-group">
            <label>Numéro ID (non modifiable) :</label>
            <input type="text" value="<?= htmlspecialchars($categorie['id']) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="code">Code :</label>
            <input type="text" name="code" value="<?= htmlspecialchars($categorie['code']) ?>" required>
        </div>

        <div class="form-group">
            <label for="label">Nouveau Label :</label>
            <input type="text" name="label" value="<?= htmlspecialchars($categorie['label']) ?>" required>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <button type="submit">Mise à jour</button>
            <a href="../administration.php" class="btn-annuler" style="background-color: #6c757d; color: white; padding: 10px; text-decoration: none; border-radius: 4px; margin-left: 10px;">Retour</a>
        </div>
    </form>
</div>
</body>
</html>