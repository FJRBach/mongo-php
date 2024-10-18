<?php
require 'conectar.php';

$database = connectMongoDB();
$usersCollection = $database->users; // Selecciona la colección 'users'

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    // Obtener el número de control más alto existente
    $lastUser = $usersCollection->findOne(
        [],
        [
            'sort' => ['numeroControl' => -1],
            'projection' => ['numeroControl' => 1]
        ]
    );
    // Se verificar sí existe el número de control y se le suma; de no ser el caso se crea desde 23999
    $lastNumeroControl = $lastUser ? intval($lastUser['numeroControl']) : 23999;
    $newNumeroControl = $lastNumeroControl + 1;

    // Inserta el documento en la colección
    $result = $usersCollection->insertOne([
        'nombre' => $nombre,
        'telefono' => $telefono,
        'numeroControl' => (string)$newNumeroControl
    ]);

    if ($result->getInsertedCount() == 1) {
        echo "Usuario agregado exitosamente.";
    } else {
        echo "Error al agregar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Usuario</h1>
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <input type="submit" value="Agregar Usuario">
        </form>

        <div class="link">
            <a href="list.php">Listar Alumnos</a>
        </div>
    </div>
</body>
</html>
