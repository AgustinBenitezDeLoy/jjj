<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Entrada</title>
</head>
<body>
    <h2>Publicar Nueva Entrada</h2>
    <form action="procesar_entrada.php" method="post">
        <!-- Aquí incluimos obtener_fiestas.php para obtener las fiestas disponibles -->
        <?php include 'obtener_fiestas.php'; ?>
        
        <label for="fiesta">Elige una fiesta:</label><br>
        <select id="fiesta" name="fiesta" required>
            <?php
            if ($fiestas->num_rows > 0) {
                // Generamos una opción por cada fiesta disponible
                while ($fila = $fiestas->fetch_assoc()) {
                    echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                }
            } else {
                echo "<option>No hay fiestas disponibles</option>";
            }
            // No olvides cerrar la conexión a la base de datos cuando ya no sea necesaria
            $conn->close();
            ?>
        </select><br>
        <input type="submit" value="Publicar Entrada">
    </form>
</body>
</html>
