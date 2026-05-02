<?php
require_once 'config.php';

try {
    // On cherche les produits qui appartiennent à la catégorie 'PC'
    $sql = "SELECT p.* FROM produits p 
            JOIN categories c ON p.categorie_id = c.id 
            WHERE c.label = 'PC'";
            
    $stmt = $pdo->query($sql);
    $produits = $stmt->fetchAll();

    // Si la base est vide, on force $produits à être un tableau vide au lieu de "null"
    if (!$produits) {
        $produits = [];
    }
} catch (Exception $e) {
    $produits = [];
    // echo "Erreur : " . $e->getMessage(); // Optionnel pour le débug
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion PC - Omnistock Vesta</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="categorie_body">
        <header class="head">
            <h2>🛍 Omnistock Vesta</h2>
        </header>
        
        <h3>Categorie PC</h3>

        <div class="zone_recherche">
            <input type="text" placeholder="Rechercher un produit...">
            <button class="bouton_ok">OK</button>
            <button class="bouton_ajouter">
                <a href="partie_php/Ajouter_produit.php" style="text-decoration:none; color:inherit;">+ Ajouter</a>
            </button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($produits) > 0): ?>
                    <?php foreach ($produits as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['nom']) ?></td>
                        <td><?= htmlspecialchars($p['description']) ?></td>
                        <td><?= htmlspecialchars($p['quantite']) ?></td>
                        <td><?= htmlspecialchars($p['prix']) ?> FCFA</td>
                        <td>
                            <button class="btn_dus-details">
                                <a href="details.php?id=<?= $p['id'] ?>">⚙ Details</a>
                            </button>
                            
                            <button class="btn_dus-update">
                                <a href="Mettre_à_jour_produit.php?id=<?= $p['id'] ?>">⬆ Update</a>
                            </button>

                            <button class="btn_dus-sup">
                                <a href="supprimer.php?id=<?= $p['id'] ?>" onclick="return confirm('Es-tu sûr de vouloir supprimer ce produit ?');">
                                Supprimer
                                </a>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Aucun produit trouvé dans cette catégorie.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer class="footer">
        @$ 2026 🛍 Omnistock Vesta - tous droits réservés<br>
        Gestion de produit<br>
        email: groupe8@gmail.com | numero: 76 87 97 74<br>
        yuta@okkotsu
    </footer>
</body>
</html>