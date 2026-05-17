<?php
require_once 'config.php';

// Nombre de produits par page
$limite = 5;

// Page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

// Position de départ
$debut = ($page - 1) * $limite;

// Recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Compter le nombre total de produits
$sqlCount = "SELECT COUNT(*) as total
             FROM produits p
             JOIN categories c ON p.categorie_id = c.id
             WHERE c.label = 'PC'
             AND p.nom LIKE :search";

$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute([
    'search' => "%$search%"
]);

$totalProduits = $stmtCount->fetch()['total'];

// Nombre total de pages
$totalPages = ceil($totalProduits / $limite);

// Requête principale avec pagination
$sql = "SELECT p.*, c.label
        FROM produits p
        JOIN categories c ON p.categorie_id = c.id
        WHERE c.label = 'PC'
        AND p.nom LIKE :search
        LIMIT $debut, $limite";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'search' => "%$search%"
]);

$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion PC - Omnistock Vesta</title>
    <link rel="stylesheet" href="../style4.css?= time(); ?>">
</head>
<body>
    <div class="categorie_body">
        <header class="head">
            <h2>🛍 Omnistock Vesta</h2>
        </header>
        
        <h3>Categorie PC</h3>

        <div class="zone_recherche">
            <form method="GET" action="pc2.php" style="display: inline-block;">
                <input type="text" name="search" placeholder="Rechercher un produit..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="bouton_ok">OK</button>
            </form>

            <button class="bouton_ajouter">
                <a href="Ajouter_produit.php" style="text-decoration:none; color:inherit;">+ Ajouter</a>
            </button>
            <button class="bouton_ajouter"><a href="../administration.php">retour</a></button>
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
                        <td colspan="6" style="text-align:center;">Aucun produit trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination">

            <?php if($page > 1){ ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">
                    Précédent
                </a>
            <?php } ?>

            <?php for($i = 1; $i <= $totalPages; $i++){ ?>

                <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"
                class="<?php if($i == $page) echo 'active'; ?>">
                <?php echo $i; ?>
                </a>

            <?php } ?>

            <?php if($page < $totalPages){ ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">
                    Suivant
                </a>
            <?php } ?>

        </div>
    </div>

    <footer class="footer">
        @$ 2026 🛍 Omnistock Vesta - tous droits réservés<br>
        Gestion de produit<br>
        email: groupe8@gmail.com | numero: 76 87 97 74<br>
        yuta@okkotsu
    </footer>
</body>
</html>