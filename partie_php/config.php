<?php
// config.php
$host = 'localhost';
$db   = 'boutique_db'; //  NOM DE LA BDD
$user = 'root';
$pass = ''; // Sur XAMPP, le mot de passe est vide par défaut
$charset = 'utf8mb4';// premet a php de comprendre les accents les emojie et autre

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";//dsn data source name: adresse de livraison
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {// attrape l'erreur au lieu de planter la bd
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>