<?php

require '../Confi/database.php';
require '../Confi/confi.php';

// Verificar si se ha proporcionado un ID de producto válido
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $db = new Database();
        $conn = $db->conectar();

        // Obtener la información del producto
        $sql = "SELECT id, nombre, descricion, precio, categoria, Cantidad FROM productos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el producto
        if(!$producto) {
            echo "No se encontró el producto.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener el producto: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}

// Procesar el formulario enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $Cantidad = $_POST['Cantidad'];

    try {
        // Actualizar los datos del producto en la base de datos
        $sql_update = "UPDATE productos SET nombre = :nombre, descricion = :descricion, precio = :precio, categoria = :categoria, Cantidad = :Cantidad WHERE id = :id";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':nombre', $nombre);
        $stmt_update->bindParam(':descricion', $descripcion);
        $stmt_update->bindParam(':precio', $precio);
        $stmt_update->bindParam(':categoria', $categoria);
        $stmt_update->bindParam(':Cantidad', $Cantidad);
        $stmt_update->bindParam(':id', $id);
        $stmt_update->execute();
        

        header("Location: TablaProductos.php");
    } catch (PDOException $e) {
        echo "Error al actualizar el producto: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include  'header.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Editar Producto</h2>
        <form action="editar_producto.php?id=<?php echo $producto['id'];?>" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $producto['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" ><?php echo $producto['descricion']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" class="form-control" value="<?php echo $producto['precio']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo $producto['categoria']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categoria">Cantidad:</label>
                <input type="text" id="Cantidad" name="Cantidad" class="form-control" value="<?php echo $producto['Cantidad']; ?>" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Guardar Cambios">
            <a href="TablaProductos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <?php include  'header.php'; ?>

    <!-- Agregar enlaces a los archivos JavaScript de Bootstrap (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
