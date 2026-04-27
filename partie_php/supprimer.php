<?php
include 'connexion.php';

$id = $_GET['id'];

$sql = "DELETE FROM produit WHERE id = $id";

if(mysqli_query($conn, $sql)){
    header("Location: pc.php");
}
?> 
<a href="supprimer.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">*/