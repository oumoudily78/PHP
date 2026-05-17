<?php
// 1. On appelle la config
require_once 'config.php';

// On récupère la recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    // 2. Requête SQL avec JOIN (comme pour le PC)
    // On utilise :s1 et :s2 pour éviter l'erreur SQL de tout à l'heure
    if (!empty($search)) {
        $sql = "SELECT p.*, c.label FROM produits p 
                JOIN categories c ON p.categorie_id = c.id 
                WHERE c.label = 'Voile' 
                AND (p.nom LIKE :s1 OR p.description LIKE :s2)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            's1' => "%$search%",
            's2' => "%$search%"
        ]);
    } else {
        $sql = "SELECT p.*, c.label FROM produits p 
                JOIN categories c ON p.categorie_id = c.id 
                WHERE c.label = 'Voile'";
        $stmt = $pdo->query($sql);
    }
    
    $produits = $stmt->fetchAll();
} catch (Exception $e) {
    die("Erreur lors de la récupération : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Voile - Omnistock Vesta</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="categorie_body">
        <header class="head">
            <h2>🛍 Omnistock Vesta</h2>
        </header>
        
        <h3>Categorie Voile</h3>

        <div class="zone_recherche">
            <form method="GET" action="" style="display: flex; width: 100%; gap: 10px;">
                <input type="text" name="search" placeholder="Rechercher un voile..." value="<?= htmlspecialchars($search) ?>" style="flex-grow: 1;">
                <button type="submit" class="bouton_ok">OK</button>
                
                <button type="button" class="bouton_ajouter">
                    <a href="Ajouter_voile.php" style="text-decoration:none; color:inherit;">Ajouter</a>
                </button>
                <button class="bouton_ajouter"><a href="../administration.php">retour</a></button>
            </form>
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
                                <a href="Mettre_à_jour_voile.php?id=<?= $p['id'] ?>">⬆ Update</a>
                            </button>

                            <button class="btn_dus-sup">
                                <a href="supprimer_produit.php?id=<?= $p['id'] ?>" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')" 
                                   style="text-decoration:none; color:inherit;">🗑 Supprimer</a>
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