<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['label']) && !empty($_POST['code'])) {
    $label = $_POST['label'];
    $code  = $_POST['code']; // On récupère le code du formulaire

    try {
        // AJOUT DE LA COLONNE 'code' DANS LA REQUÊTE
        $sql = "INSERT INTO categories (label, code) VALUES (:label, :code)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'label' => $label,
            'code'  => $code
        ]);
        header("Location: ../administration.php?success=1"); // Redirection après succès
        exit();
    } catch (PDOException $e) {
        die("Erreur MySQL : " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Categorie</title>
    <link rel="stylesheet" href="../Ajout_mise_a_jour/Sytle3.css">
</head>
<body>
    <div class="block">
        <h3>Ajouter une catégorie</h3>
        <form action="Ajouter_Categorie.php" method="POST" >
            <label for="text">Code:</label> 
            <input type="text" name="code" id="text"><br><br>
            <label for="text">Label:</label>
            <input type="text"name="label" id="text"><br><br>
            <button type="submit" >Ajouter</button>
            <a href="../administration.php">retour</a>
        </form>
    </div>
</body>
</html>