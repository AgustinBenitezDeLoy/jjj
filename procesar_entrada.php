<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fiesta'])) {
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'reentraste');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    $fiestaId = $_POST['fiesta'];

    // Suponiendo que el usuario está logueado y su ID está en $_SESSION['usuario_id']
    session_start();
    $usuarioId = $_SESSION['usuario_id'] ?? 0; // Asegúrate de que el usuario esté logueado

    // Obtén la imagen QR de la fiesta seleccionada
    if ($consultaQR = $conn->prepare("SELECT imagenQR FROM fiestas WHERE id = ?")) {
        $consultaQR->bind_param("i", $fiestaId);
        $consultaQR->execute();
        $resultadoQR = $consultaQR->get_result();
        if ($filaQR = $resultadoQR->fetch_assoc()) {
            $imagenQR = $filaQR['imagenQR'];
            
            // Inserta la entrada en la base de datos
            if ($insertarEntrada = $conn->prepare("INSERT INTO entradas (usuario_id, fiesta_id, codigo_qr) VALUES (?, ?, ?)")) {
                $insertarEntrada->bind_param("iis", $usuarioId, $fiestaId, $imagenQR);
                if ($insertarEntrada->execute()) {
                    echo "Entrada publicada con éxito.";
                } else {
                    echo "Error al publicar la entrada: " . $insertarEntrada->error;
                }
                $insertarEntrada->close();
            }
        }
        $consultaQR->close();
    }
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>
