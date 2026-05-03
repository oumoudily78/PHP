<?php
var_dump($_POST);
// 1. Connexion à la base
require_once 'config.php'; 

$message = "";

// 2. Traitement si on clique sur le bouton
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['label'])) {
    $label = $_POST['label'];
    try {
        $sql = "INSERT INTO categories (label) VALUES (:label)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['label' => $label]);
        echo "Succès !"; 
    } catch (PDOException $e) {
        // Cela va t'afficher la VRAIE erreur si MySQL refuse
        die("Erreur MySQL : " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Categorie</title>
    <link rel="stylesheet" href="../Ajout_mise_a_jour/sytle3.css">
</head>
<body>
    <div class="block">
        <h3>Ajouter une catégorie</h3>
        <?php echo $message; ?>
        <form action="Ajouter_Categorie.php" method="POST" >
            <label for="text">Code:</label> 
            <input type="text" name="code" id="text"><br><br>
            <label for="text">Label:</label>
            <input type="text"name="label" id="text"><br><br>
            <button type="submit" >Ajouter</button>
        </form>
    </div>
</body>
</html>