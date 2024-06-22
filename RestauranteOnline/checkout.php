<?php

require 'Confi/database.php';
require 'Confi/confi.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if ($productos != null) {

    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad as cantidad FROM productos WHERE id=? AND active=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link href="css/estilo.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

<?php include'menu.php'; ?>

    <main>
        <div class="container">
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
                        <?php
                        if ($lista_carrito == null) {
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                        } else {

                            $total = 0;
                            foreach ($lista_carrito as $productos) {
                                foreach ($productos as $producto) {
                                    $_id = $producto['id'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $descuento = $producto['descuento'];
                                    $cantidad = $producto['cantidad'];
                                    $precio_desc = $precio - ($precio * $descuento) / 100;
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                        ?>
                                    <tr>
                                        <td><?php echo $nombre; ?></td>
                                        <td><?php echo Moneda .  number_format($precio_desc, 2, '.', ','); ?></td>
                                        <td>
                                            <input type="number" min="1" max="1000" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" class="text-center" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)" />
                                        </td>
                                        <td>
                                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo Moneda . number_format($subtotal, 2, '.', ','); ?></div>

                                        </td>
                                        <td class="text-center"><a href="#" id="#eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>

                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo Moneda . number_format($total, 2, ',', '.'); ?></p>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
                
            </div>
            <div>
            <?php if ($lista_carrito != null) {?>
                    <div class="row">
                        <div class="col-md-5 offset-md-7 d-grid gap-2">
                          <?php if(isset($_SESSION['user_cliente'])) {?>
                            <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
                            <?php } else { ?>
                                <a href="login.php?pago" class="btn btn-primary btn-lg">Debes iniciar secion para realizar pago</a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <?php } ?>
        </div>
    </main>

<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alerta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Seguro que quieres eliminar el proyecto de la lista?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
      </div>
    </div>
  </div>
</div>
    <script>
        
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })

    function actualizaCantidad(cantidad, id) {


        var formData = new FormData();
        formData.append('action', 'agregar');
        formData.append('id', id);
        formData.append('cantidad', cantidad);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'clases/actualizar_carrito.php', true);

        xhr.onload = function () {
            if (xhr.status == 200) {
                try {
                    var respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.ok) {
                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = respuesta.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')

                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[<?php echo Moneda; ?>,]/g, ''))
                        }

                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total)

                        document.getElementById('total').innerHTML = '<?php echo Moneda; ?>' + total

                    } else {
                        // Manejo de error
                        console.error('Error en la respuesta:', respuesta);
                    }
                } catch (error) {
                    console.error('Error al analizar la respuesta JSON:', error);
                }
            } 
        };

        xhr.send(formData);
    }
    function eliminar() {
        
        let botonElimina =document.getElementById("btn-elimina")
        let id = botonElimina.value

        var formData = new FormData();
        formData.append('action', 'eliminar');
        formData.append('id', id);


        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'clases/actualizar_carrito.php', true);

        xhr.onload = function () {
            if (xhr.status == 200) {
                try {
                    var respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.ok) {
                        location.reload()
                    } else {
                        // Manejo de error
                        console.error('Error en la respuesta:', respuesta);
                    }
                } catch (error) {
                    console.error('Error al analizar la respuesta JSON:', error);
                }
            } 
        };

    xhr.send(formData);
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>