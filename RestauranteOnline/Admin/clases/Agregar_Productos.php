<?php

require '../Confi/database.php';
require '../Confi/confi.php';

try {
    $db = new Database();
    $conn = $db->conectar();

    // Obtener los datos del formulario y verificar si están definidos
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $Cantidad = isset($_POST['Cantidad']) ? $_POST['Cantidad'] : '';

    $sql = $conn->prepare("INSERT INTO productos (nombre, descricion, precio, categoria, Cantidad) VALUES (?, ?, ?, ?, ?)");
    $sql->execute([$nombre, $descripcion, $precio, $categoria, $Cantidad]);
    $id = $conn->lastInsertId();

    if ($id) {
        echo "Producto agregado correctamente.";

        // Crear la carpeta para las imágenes
        $carpeta = "../../imagenes/productos/" . $id;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        } else {
            echo "La carpeta ya existe.";
        }
        
        // Procesar las imágenes
        if(isset($_FILES['imagenes'])) {
            $total = count($_FILES['imagenes']['name']);
            for( $i = 0; $i < $total; $i++ ) {
                $nombreArchivo = $_FILES['imagenes']['name'][$i];
                $temporal = $_FILES['imagenes']['tmp_name'][$i];
                // Obtener la extensión del archivo
                $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                // Nombre de archivo base
                $nombreBase = ($i == 0) ? 'principal' : 'principal' . $i;
                // Generar un nombre único basado en el nombre base y la fecha y hora actual
                $nombreUnico = $nombreBase . '.jpg';
                // Ruta donde se guardará la imagen
                $ruta = $carpeta . '/' . $nombreUnico;
                if(move_uploaded_file($temporal, $ruta)) {
                    echo "Imagen $nombreArchivo subida correctamente.<br>";
                } else {
                    echo "Error al subir la imagen $nombreArchivo.<br>";
                }
            }
        }
        header("Location: ../AgregarProducto.php");
        
    } else {
        echo "Error al agregar el producto.";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

// Cerrar conexión
$conn = null;
?>
