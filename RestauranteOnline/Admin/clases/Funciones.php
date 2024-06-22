<?php 
require '../Confi/database.php';
require '../Confi/confi.php';


function Activo($categoria) {
    // Crear una nueva instancia de la clase Database y conectar a la base de datos
    $db = new Database();
    $conn = $db->conectar();

    // Consultar todos los productos que pertenecen a la categoría especificada
    $sql = "SELECT active FROM productos WHERE categoria = :categoria";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si no hay productos en la categoría, retornar true (o false según la lógica que necesites)
    if (empty($productos)) {
        return true;  // o true, según lo que desees en este caso
    }

    // Verificar si al menos uno de los productos está activo (active = 1)
    foreach ($productos as $producto) {
        if ($producto['active'] == 1) {
            return true;
        }
    }

    // Si ningún producto está activo, retornar false
    return false;
}