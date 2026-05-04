<?php
require_once 'partie_php/config.php'; // Vérifie bien le chemin vers ton config.php

try {
    // On récupère toutes les catégories de la base de données
    $stmt = $pdo->query("SELECT * FROM categories");
    $liste_categories = $stmt->fetchAll();
} catch (Exception $e) {
    $liste_categories = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="style.css">
</head>
<script>
function supprimerLigne(btn) {
    if (confirm("Voulez-vous supprimer ce produit ?")) {
        btn.parentNode.parentNode.remove();
    }
}
</script>
<body>
    <header class="head">
        <h2>🛍 Omnistock Vesta</h2>
    </header>
    <div class="dashboard">

        <aside class="sidebar">
            <ul>
                <li><a href="accueil.php"><button class="menu-btn active">🏠 Accueil</button></a></li>
                <li class="active"><a href="administration.html"><button class="menu-btn active">⚙️ Administration</button></a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <h1>Gestion des Categorie</h1>
            <div class="zone_recherche">
                <input type="text" placeholder="Rechercher une catégorie...">
                <button class="bouton_ok"><a href="supp-details/rechercher.html">OK</a></button>
            </div>
            <div class="category-tabs">
                <button class="card"><a href="partie_php/pc2.php">PC</a></button>
                <button class="card"><a href="partie_php/voile2.php">Voile</a></button>
                <button class="bouton_ajouter"><a href="partie_php/Ajouter_Categorie.php">➕</a></button>
            </div>
            <h2>Liste des categorie</h2>
            <table class="admin-table">
                <tbody>
                    <?php if (!empty($liste_categories)): ?>
                        <?php foreach ($liste_categories as $cat): ?>
                            <tr>
                                <td><?= htmlspecialchars($cat['id']) ?></td>
                                <td><?= htmlspecialchars($cat['code']) ?></td>
                                <td><?= htmlspecialchars($cat['label']) ?></td>
                                <td>
                                    <button class="btn_dus-update">
                                        <a href="partie_php/Mise_à_jour_Categorie.php?id=<?= $cat['id'] ?>">Update</a>
                                    </button>
                                    
                                    <button class="btn_dus-sup">
                                        <a href="partie_php/supprimer.php?id=<?= $cat['id'] ?>&type=categorie" onclick="return confirm('Supprimer  cette categorie?');">Supprimer</a>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">Aucune catégorie trouvée.</td>
                        </tr>
                    <?php endif; ?>
</tbody>
            </table>
        </main>
    </div>
    <footer class="footer">
        @$ 2026 🛍 Omnistock Vesta - tous droits réservés
        Gestion de produit<br>
        email: groupe8@gmail.com<br>
        numero: 76 87 97 74<br>
        yuta@okkotsu<br>
    </footer>
</body>
</html>