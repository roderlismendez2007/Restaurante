<?php

require 'Confi/database.php';
require 'Confi/confi.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
  echo 'Error al procesar la peticion';
  exit;
} else {

  $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

  if ($token == $token_tmp) {

    $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND active=1");
    $sql->execute([$id]);
    if ($sql->fetchColumn() > 0) {

      $sql = $con->prepare("SELECT nombre, descricion, precio, descuento FROM productos WHERE id=? AND active=1
      LIMIT 1");
      $sql->execute([$id]);
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $nombre = $row['nombre'];
      $descricion = $row['descricion'];
      $precio = $row['precio'];
      $descuento = $row['descuento'];
      $precio_desc = $precio - (($precio * $descuento) / 100);
      $dir_imagenes = 'imagenes/productos/' . $id . '/';

      $rutaImg = $dir_imagenes . 'principal.jpg';
      if (!file_exists($rutaImg)) {
        $rutaImg = 'imagenes/f2.avif';
      }

      $dir_imagenes = 'imagenes/productos/1/'; // Asegúrate de que esta ruta es correcta
$imagenes = array();

if (is_dir($dir_imagenes)) {
    $dir = dir($dir_imagenes);

    while (($archivo = $dir->read()) !== false) {
        if ($archivo != "principal.jpg" && (strpos($archivo, "jpg") !== false || strpos($archivo, "jpeg") !== false)) {
            $imagenes[] = $dir_imagenes . $archivo;
        }
    }
    $dir->close();

    // Verificar si hay imágenes en la carpeta antes de continuar
    if (!empty($imagenes)) {
        // Coloca aquí el código que quieres que se ejecute si hay imágenes
    } 
} 



    }
  } else {
    echo 'Error al procesar la peticion';
    exit;
  }
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <style>
    .notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(50%);
            z-index: 1000;
            max-width: 400px;
            width: 90%;
        }
    </style>
    <link href="css/estilo.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    
<?php include'menu.php'; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">


                    <div id="caru" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="4000">
                                <img src="<?php echo $rutaImg; ?>" class="d-block w-75">
                            </div>
                            <?php foreach ($imagenes as $img) { ?>
                            <div class="carousel-item" data-bs-interval="4000">
                                <img src="<?php echo $img; ?>" class="d-block w-75">
                            </div>
                            <?php  } ?>
                             <button class="carousel-control-prev" type="button" data-bs-target="#caru" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#caru" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-md-2">
                    <h1><?php echo $nombre; ?></h1>
                    <?php if ($descuento > 0) { ?>
                    <p><del>$<?php echo number_format($precio, 2, '.', ','); ?></del></p>
                    <h2>
                        $<?php echo number_format($precio_desc, 2, '.', ','); ?>
                        <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                    </h2>
                    <?php } else { ?>

                    <h2>$<?php echo  number_format($precio, 2, '.', ','); ?></h2>
                    <?php } ?>

                    <p class="lead">
                        <?php echo $descricion; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-outline-primary" type="button"
                            onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al
                            platillo</button>
                    </div>

                </div>
            </div>

        </div>
        </div>
    </main>
    <script src="scrips/agregar_producto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
<script>
        // Función para mostrar la notificación
        function mostrarNotificacion(nombreProducto) {
            const notificacion = document.createElement('div');
            notificacion.classList.add('notification', 'alert', 'alert-success');
            notificacion.innerHTML = `
                <strong>Producto agregado:</strong> ${nombreProducto}
            `;
            document.body.appendChild(notificacion);
            setTimeout(() => {
                notificacion.remove();
            }, 1000); // La notificación desaparecerá después de 3 segundos
        }

        // Agregar un evento clic a todos los botones de "Agregar al carrito"
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const nombreProducto = button.getAttribute('data-product-name');
                mostrarNotificacion(nombreProducto);
            });
        });
    </script>

</body>

</html>