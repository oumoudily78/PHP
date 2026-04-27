<?php
$serveur = "localhost";
$utilisateur = "root";
$motdepasse= "";
$base = "boutique_db";

$conn = mysqli_connect($serveur,$utilisateur,$motdepasse,$base);
if(!$conn){
    die("Connexion échouée : " .mysqli_connect_error());
}
?>