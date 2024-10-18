<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta a autoload.php sea correcta

function connectMongoDB() {
    $uri = "mongodb://localhost:27017"; // Cambia si es necesario
    $client = new MongoDB\Client($uri);
    $database = $client->selectDatabase('bachur'); // Nombre de tu base de datos
    return $database;
}
?>
