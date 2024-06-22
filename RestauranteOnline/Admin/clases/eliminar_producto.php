<?php

require '../Confi/database.php';
require '../Confi/confi.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $db = new Database();
        $conn = $db->conectar();

        // Obtener la información del producto para eliminar la carpeta
        $sql = "SELECT id FROM productos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if($producto) {
            // Eliminar el producto de la base de datos
            $sql_delete = "DELETE FROM productos WHERE id = :id";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':id', $id);
            $stmt_delete->execute();

            // Eliminar la carpeta y su contenido
            $carpeta = "../../imagenes/productos/" . $id;
            if (file_exists($carpeta)) {
                eliminarCarpeta($carpeta);
            }

            echo "Producto eliminado correctamente.";
        header("Location: ../TablaProductos.php");

        } else {
            echo "No se encontró el producto.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
} else {
    echo "ID de producto no proporcionado.";
}

// Función para eliminar una carpeta y su contenido
function eliminarCarpeta($dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            is_dir($file) ? eliminarCarpeta($file) : unlink($file);
        }
        rmdir($dir);
    }
}

?>
