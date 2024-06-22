<?php

    require 'Confi/database.php';
    require 'Confi/confi.php';

    $db = new Database();
    $con = $db->conectar();
    //session_destroy();

    $token_session = $_SESSION['token'];

    $orden = $_GET['orden'] ?? null;
    $token = $_GET['token'] ?? null;

    if ($orden == null || $token == null || $token != $token_session) {
    header("Location: compras.php");
    exit;
    }

    $sqlCompra = $con->prepare("SELECT id, id_transaccion, fecha, total FROM compra WHERE id_transaccion = ? LIMIT 1");
    $sqlCompra->execute([$orden]);

    $rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
    $idCompra = $rowCompra['id'];
    $sqlDetalle = $con->prepare("SELECT id, nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
    $sqlDetalle->execute([$idCompra]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante Online</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="CSS/estilo.css" rel="stylesheet">
</head>

<body>

   <?php include'menu.php'; ?>

    <main>
        <div class="container">

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Detalle de la compra</strong>
                    </div>
                    <div class="card-body">
                    <p><strong>Fecha: </strong> <?php echo $rowCompra['fecha']; ?></p>
                    <p><strong>Orden: </strong> <?php echo $rowCompra['id_transaccion']; ?></p>
                    <p><strong>Total: </strong> <?php echo $rowCompra['total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="table-responsive">
                    <table class="table">
                    <thead>
    <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
        <th></th>
    </tr>
</thead>

<tbody>
    <?php while ($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) {

        $precio = $row['precio'];
        $cantidad = $row['cantidad'];
        $subtotal = $precio * $cantidad;
    ?>
        <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $precio; ?></td>
            <td><?php echo $cantidad; ?></td>
            <td><?php echo $subtotal; ?></td>
            <td></td>
        </tr>
    <?php } ?>
</tbody>
                    </table>

                </div>
            </div>

        </div>

  </div>

    </main>

    <script src="scrips/agregar_producto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 

</body>

</html>