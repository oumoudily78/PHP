<?php
include("connexion.php");

$sql = "SELECT * FROM produits WHERE categorie_id = 2";
$resultat = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produits PC</title>
</head>
<body>

<h2>Liste des PC</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Quantité</th>
        <th>Prix</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($resultat)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nom']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['quantite']; ?></td>
            <td><?php echo $row['prix']; ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>