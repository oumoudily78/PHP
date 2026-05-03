<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // On regarde si on veut supprimer une catégorie ou un produit (par défaut produit)
    $type = isset($_GET['type']) ? $_GET['type'] : 'produit';

    try {
        if ($type === 'categorie') {
            // Suppression d'une catégorie
            $sql = "DELETE FROM categories WHERE id = ?";
            $redirect = "../administration.php";
        } else {
            // Suppression d'un produit
            $sql = "DELETE FROM produits WHERE id = ?";
            // On redirige vers pc2.php ou voile2.php (on peut utiliser history.back)
            $redirect = "javascript:history.back()"; 
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Redirection
        if ($redirect === "javascript:history.back()") {
            echo "<script>window.location.href=document.referrer;</script>";
        } else {
            header("Location: $redirect");
        }
        exit();

    } catch (Exception $e) {
        die("Erreur de suppression : " . $e->getMessage());
    }
}