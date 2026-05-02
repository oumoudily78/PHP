<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "Tentative de suppression du produit ID : " . $id; // Test d'affichage

    try {
        $sql = "DELETE FROM produits WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        echo " --- Succès ! Le produit a été effacé.";
        echo "<br><a href='pc2.php'>Cliquez ici pour voir</a>";
        exit(); // On arrête tout ici pour lire le message
    } catch (Exception $e) {
        die("Erreur MySQL : " . $e->getMessage());
    }
}
?>