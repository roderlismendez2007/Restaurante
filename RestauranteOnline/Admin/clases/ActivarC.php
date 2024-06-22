<?php

require '../Confi/database.php';
require '../Confi/confi.php';

// Verificar si se recibió la categoría y el estado
if (isset($_GET['categoria']) && !empty($_GET['categoria']) && isset($_GET['estado'])) {
    $categoria = $_GET['categoria'];
    $estado = $_GET['estado'];

    try {
        // Crear una nueva instancia de la clase Database y conectar a la base de datos
        $db = new Database();
        $conn = $db->conectar();

        // Actualizar el estado de todos los productos en la categoría especificada
        $sql_update = "UPDATE productos SET active = :active WHERE categoria = :categoria";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':active', $estado);
        $stmt_update->bindParam(':categoria', $categoria);
        $stmt_update->execute();

        // Redirigir a la página de categorías después de la actualización
        header("Location: ../categorias.php");
        exit;
    } catch (PDOException $e) {
        // Mostrar un mensaje de error si ocurre una excepción
        echo "Error al actualizar los productos: " . $e->getMessage();
        exit;
    }
} else {
    // Redirigir a la página de categorías si no se recibieron parámetros válidos
    header("Location: ../categorias.php");
    exit;
}
?>

