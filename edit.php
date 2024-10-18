<?php
require 'conectar.php';

$database = connectMongoDB();
$usersCollection = $database->users; // Selecciona la colección 'users'

// Verifica si se proporciona el número de control
if (isset($_GET['numeroControl'])) {
    $numeroControl = $_GET['numeroControl'];

    // Busca el usuario por número de control
    $user = $usersCollection->findOne(['numeroControl' => $numeroControl]);

    if (!$user) {
        die("Usuario no encontrado.");
    }
} else {
    die("Número de control no proporcionado.");
}

// Manejo del formulario para actualizar el usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    // Actualiza el usuario
    $result = $usersCollection->updateOne(
        ['numeroControl' => $numeroControl],
        ['$set' => ['nombre' => $nombre, 'telefono' => $telefono]]
    );

    if ($result->getModifiedCount() == 1) {
        echo "Usuario actualizado exitosamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Usuario</h1>
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>" required>

            <input type="submit" value="Actualizar Usuario">
        </form>
        <div class="link">
            <a href="list.php">Volver a la lista de alumnos</a>
        </div>
    </div>
</body>
</html>
