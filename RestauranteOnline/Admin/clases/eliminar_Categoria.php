<?php

require '../Confi/database.php';
require '../Confi/confi.php';

if(isset($_POST['categoria'])) {
    $categoria = $_POST['categoria'];

    try {
        $db = new Database();
        $conn = $db->conectar();

        // Obtener la información de los productos de la categoría para eliminar las carpetas
        $sql = "SELECT id FROM productos WHERE categoria = :categoria";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($productos) {
            // Eliminar los productos de la base de datos
            $sql_delete = "DELETE FROM productos WHERE categoria = :categoria";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':categoria', $categoria);
            $stmt_delete->execute();

            // Eliminar las carpetas y su contenido
            foreach ($productos as $producto) {
                $carpeta = "../../imagenes/productos/" . $producto['id'];
                if (file_exists($carpeta)) {
                    eliminarCarpeta($carpeta);
                }
            }

            echo "Productos eliminados correctamente.";
            header("Location: ../categorias.php");
            exit;

        } else {
            echo "No se encontraron productos en la categoría especificada.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar los productos: " . $e->getMessage();
    }
} else {
    echo "Categoría no proporcionada.";
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