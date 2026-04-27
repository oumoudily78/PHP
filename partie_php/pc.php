<?php
include("connexion.php");

$sql = "SELECT * FROM produit WHERE categorie = 'PC'";
$result = mysqli_query($conn, $sql);
?>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nom']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['quantite']; ?></td>
        <td><?php echo $row['prix']; ?></td>
        <td>
            <a href="supprimer.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Voulez-vous supprimer ?')">
               🗑 Supprimer
            </a>
        </td>
    </tr>
    <?php } ?>
</table>