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
            <!--Verificar zona horaria: https://www.php.net/manual/es/timezones.america.php -->
            <?php
            require 'conectar.php';
            $database = connectMongoDB();
            $usersCollection = $database->users; // Selecciona la colección 'users'

            $users = $usersCollection->find();
            // Declarar que se utilizará la zona horaria de México
            date_default_timezone_set('America/Mexico_City'); 

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
                echo "<td><a class='edit-button' href='edit.php?numeroControl=" . htmlspecialchars($user['numeroControl']) . "'>Editar</a></td>";
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
