<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Alumnos</h1>
        <?php
        require 'conectar.php';
        $database = connectMongoDB();
        $usersCollection = $database->users; // Selecciona la colección 'users'

        // Manejar eliminación de usuario
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numeroControlEliminar'])) {
            $numeroControlEliminar = $_POST['numeroControlEliminar'];
            $usersCollection->deleteOne(['numeroControl' => $numeroControlEliminar]);
            echo "<p>Usuario con número de control " . htmlspecialchars($numeroControlEliminar) . " eliminado.</p>";
        }

        $users = $usersCollection->find();
        // Declarar que se utilizará la zona horaria de México
        date_default_timezone_set('America/Mexico_City'); 
        ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha de creación</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Número de Control</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user) {
                echo "<tr>";
                // Decodificar el ObjectId para mostrar la zona horaria
                $objectId = new MongoDB\BSON\ObjectId($user['_id']);
                $timestamp = $objectId->getTimestamp(); // Obtener el timestamp
                $fechaCreacion = date('Y-m-d H:i:s', $timestamp); // Formatear la fecha

                echo "<td>" . htmlspecialchars($fechaCreacion) . "</td>"; // Mostrar la fecha
                echo "<td>" . htmlspecialchars($user['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($user['telefono']) . "</td>";
                echo "<td>" . htmlspecialchars($user['numeroControl']) . "</td>";
                echo "<td>";
                echo "<a class='edit-button' href='edit.php?numeroControl=" . htmlspecialchars($user['numeroControl']) . "'>Editar</a><br>";
                echo " ";
                echo "<form method='POST' action='' style='display:inline;'>";
                echo "<input type='hidden' name='numeroControlEliminar' value='" . htmlspecialchars($user['numeroControl']) . "'>";
                echo "<input class='delete-button' type='submit' value='Eliminar' onclick=\"return confirm('¿Está seguro de que desea eliminar este usuario?');\">";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="button-container">
            <a href="index.php">Agregar otro alumno</a>
        </div>
    </div>
</body>
</html>
