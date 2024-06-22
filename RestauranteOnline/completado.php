<?php

    require 'Confi/database.php';
    require 'Confi/confi.php';
    require 'clases/clienteFunciones.php';
    $db = new Database();
    $con = $db->conectar();
    //session_destroy();
    $orden = $_GET['orden'] ?? null;

    if ($orden == null) {
    header("Location: index.php");
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
    <title>Tienda Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>
<?php include("menu.php") ?>
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
                        <p><strong>Total: </strong> <?php echo Moneda . number_format($rowCompra['total'], 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php   
                             while ($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) { 
                                $Producto = $row['nombre'];
                                $precio = $row['precio'];
                                $cantidad = $row['cantidad'];
                                $subTotal = number_format($precio * $cantidad,  2);
                        ?> 
                        <tr>
                            <td><?php echo $Producto ?></td>
                            <td><?php echo Moneda . number_format($precio,2); ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td><?php echo Moneda . $subTotal ;?>   </td>
                        </tr>
                        <?php } ?>

            </div>
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 



</body>
</html>