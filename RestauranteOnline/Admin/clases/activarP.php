<?php
require '../Confi/database.php';
require '../Confi/confi.php';

try {
    $db = new Database();
    $conn = $db->conectar();

    if (isset($_GET['id']) && isset($_GET['valor'])) {
        $id = $_GET['id'];
        $valor = $_GET['valor'];

        $sql = "UPDATE productos SET active = :valor WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../TablaProductos.php"); // Redirigir a la página de productos
            exit();
        } else {
            echo "Error al actualizar el estado del producto.";
        }
    } else {
        echo "Parámetros inválidos.";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
