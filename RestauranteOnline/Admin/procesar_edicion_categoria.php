<?php
require '../Confi/database.php';
require '../Confi/confi.php';
// Verificar si se recibió el ID de la categoría a editar


if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];


} else {
  
    header("Location: categorias.php");
    exit(); 
}
// Si se recibió una solicitud POST, procesar la actualización de la categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nueva_categoria = $_POST['nueva_categoria'];
    
    try {
        $db = new Database();
        $conn = $db->conectar();

        // Actualizar el nombre de la categoría en todos los productos que tengan esa categoría
        $sql = "UPDATE productos SET categoria = :nueva_categoria WHERE categoria = :categoria";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nueva_categoria', $nueva_categoria);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();

        // Redirigir a la página de categorías después de la actualización
        header("Location: categorias.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar la categoría: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="mt-5">Editar Categoría</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nueva_categoria">Nombre de la Nueva Categoría</label>
                    <input type="text" class="form-control" id="nueva_categoria" name="nueva_categoria" value="<?php echo htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
