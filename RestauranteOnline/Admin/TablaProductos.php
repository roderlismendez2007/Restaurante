<?php

require '../Confi/database.php';
require '../Confi/confi.php';

try {
    $db = new Database();
    $conn = $db->conectar();

    // Obtener todos los productos de la base de datos
    $sql = "SELECT id, nombre, descricion, precio, categoria, Cantidad, active FROM productos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/esp.css">

    <!-- scripts(js) de datatable y css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish_Mexico.json" defer></script>

    <style>
        .table-description {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px; /* Ajusta el valor según tus necesidades */
        }
    </style>
</head>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });
    });
</script>

<body>
<?php include 'header.php'; ?>

<main>
    <h1>Lista de Producto</h1>

    <div class="container">
        <div class="table-responsive">
            <table id="example" class="display responsive nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td class="table-description"><?php echo substr($producto['descricion'], 0, 50) . '...'; ?></td>
                        <td><?php echo $producto['precio']; ?></td>
                        <td><?php echo $producto['categoria']; ?></td>
                        <td><?php echo $producto['Cantidad']; ?></td>
                        <td>
                            <!-- Lista de botones centrados -->
                            <div class="d-flex justify-content-center">
                                <ul class="list-inline">
                                    <li class="list-inline-item me-2">
                                        <!-- Botón para editar -->
                                        <a href="editar_producto.php?id=<?php echo $producto['id']; ?>"
                                           class="btn btn-primary btn-sm">Editar</a>
                                    </li>
                                    <li class="list-inline-item me-2">
                                        <!-- Botón para eliminar -->
                                        <form action="clases/eliminar_producto.php" method="post"
                                              style="display: inline;">
                                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro de querer eliminar este producto?')">Eliminar
                                            </button>
                                        </form>
                                    </li>
                                    <li class="list-inline-item">
                                        <?php if ($producto['active'] > 0): ?>
                                            <!-- Botón para desactivar producto -->
                                            <a href="clases/activarP.php?id=<?php echo $producto['id']; ?>&valor=0"
                                               class="btn btn-warning btn-sm">Desactivar</a>
                                        <?php else: ?>
                                            <!-- Botón para activar producto -->
                                            <a href="clases/activarP.php?id=<?php echo $producto['id']; ?>&valor=1"
                                               class="btn btn-success btn-sm">Activar</a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</main>
<?php include 'footer.php'; ?>
</body>
</html>
