<?php
require 'clases/Funciones.php';


try {
    $db = new Database();
    $conn = $db->conectar();

    // Obtener categorías únicas de los productos
    $sql = "SELECT DISTINCT categoria FROM productos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/esp.css">
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
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
                }
            });
        });
    </script>
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <h1>Lista de Categorías</h1>

    <div class="container">
        <table id="example" class="table table-striped">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categoria['categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="procesar_edicion_categoria.php?categoria=<?php echo htmlspecialchars($categoria['categoria'], ENT_QUOTES, 'UTF-8'); ?>"
                               class="btn btn-primary btn-sm">Editar</a>
                            <?php if (Activo($categoria['categoria'])) { ?>
                                <a href="clases/ActivarC.php?categoria=<?php echo htmlspecialchars($categoria['categoria'], ENT_QUOTES, 'UTF-8'); ?>&estado=0"
                                   class="btn btn-warning btn-sm">Desactivar</a>
                            <?php } else { ?>
                                <a href="clases/ActivarC.php?categoria=<?php echo htmlspecialchars($categoria['categoria'], ENT_QUOTES, 'UTF-8'); ?>&estado=1"
                                   class="btn btn-success btn-sm">Activar</a>
                            <?php } ?>
                            <form action="clases/eliminar_Categoria.php" method="post"
                                              style="display: inline;">
                                            <input type="hidden" name="categoria" value="<?php echo $categoria['categoria']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro de querer eliminar este Categoria? ¡¡todas los productos de esta cetegoria seran eliminado!!')">Eliminar
                                            </button>
                                        </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
