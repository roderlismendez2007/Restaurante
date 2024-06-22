<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include  'header.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Agregar Producto</h2>
        <form action="clases/Agregar_Productos.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" ></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="categoria">Cantidad:</label>
                <input type="text" id="Cantidad" name="Cantidad" class="form-control"  required>
            </div>
            <!-- Input para subir imágenes -->
            <div class="form-group">
                <label for="imagenes">Imágenes (máximo 4):</label>
                <input type="file" id="imagenes" name="imagenes[]" class="form-control-file" accept="image/*" multiple required>
                <small class="form-text text-muted">Puedes seleccionar hasta 4 imágenes.</small>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>
    </div>

    <?php include  'footer.php'; ?> 
    <!-- Agregar enlaces a los archivos JavaScript de Bootstrap (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
