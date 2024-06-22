<?php

require 'Confi/database.php';
require 'Confi/confi.php';
$db = new Database();
$con = $db->conectar();

// Consulta SQL para obtener todas las categorías distintas de los productos
$sql_categorias = $con->prepare("SELECT DISTINCT categoria FROM productos WHERE active=1");
$sql_categorias->execute();
$categorias = $sql_categorias->fetchAll(PDO::FETCH_COLUMN);

// Consulta SQL para obtener todos los productos ordenados por categoría
$sql_productos = $con->prepare("SELECT id, nombre, precio, categoria FROM productos WHERE active=1 ORDER BY RAND()");
$sql_productos->execute();
$resultado = $sql_productos->fetchAll(PDO::FETCH_ASSOC);

// Obtener hasta cinco productos aleatorios
$productos_aleatorios = array_slice($resultado, 0, 5);

// Creamos un array asociativo para agrupar los productos restantes por categoría
$productos_por_categoria = array();

foreach ($resultado as $producto) {
    $categoria = $producto['categoria'];
    if (!isset($productos_por_categoria[$categoria])) {
        $productos_por_categoria[$categoria] = array();
    }
    $productos_por_categoria[$categoria][] = $producto;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante Online</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
    <style>
        .img32 {
            transition: width 0.3s ease;
            object-fit: cover;
            height: 500px;
        }
        .img32:hover {
            width: 500px;
        }
        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .card:hover .overlay {
            opacity: 1;
        }
        .btn-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .card:hover .btn-overlay {
            opacity: 1;
        }
        .text-overlay {
            color: white;
            font-weight: bold;
            text-align: center;
        }
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
</head>
<body>

<?php include 'menu.php'; ?>

<main>
    <div class="container">
        <!-- Filtro de categorías -->
        <form action="#" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                <select class="form-select" name="categoria">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?php echo $categoria; ?>"><?php echo $categoria; ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
            
        </form>

        <!-- Productos filtrados -->
        <?php foreach ($productos_por_categoria as $categoria => $productos) : ?>
            <?php if (empty($_GET['categoria']) || $_GET['categoria'] === $categoria) : ?>
                <div class="my-4">
                    <h2 class="display-4 text-center mb-4"><?php echo $categoria; ?></h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <?php foreach ($productos as $producto) : ?>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <?php 
                                        $id = $producto['id'];
                                        $imagen = "imagenes/productos/" . $id . "/principal.jpg";

                                        if (!file_exists($imagen)){
                                            $imagen = "imagenes/f2.avif";
                                        }
                                    ?>
                                    <img src="<?php echo $imagen; ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                                        <p class="card-text">$ <?php echo number_format($producto['precio'], 2, '.', ','); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a href="detalles.php?id=<?php echo $producto['id']; ?>&token=<?php echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                            </div>
                                            <button class="btn btn-outline-success add-to-cart-btn" data-product-id="<?php echo $producto['id']; ?>" data-product-name="<?php echo $producto['nombre']; ?>"
                                            onclick="addProducto(<?php echo $producto['id']; ?>, '<?php echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>')">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <script src="scripts/agregar_producto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
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
        <script>
        function addProducto(idProducto, tokenUsuario) {

// Crear un formulario con los datos del producto
var formData = new FormData();
formData.append('id', idProducto);
formData.append('token', tokenUsuario);

// Obtener el elemento que muestra el número de artículos en el carrito
let numeroArticulosEnCarrito = document.getElementById("num_cart");

// Crear una solicitud XMLHttpRequest
var xhr = new XMLHttpRequest();

// Configurar la solicitud
xhr.open('POST', 'clases/Carrito.php', true);

// Función para manejar la respuesta del servidor
xhr.onreadystatechange = function () {
  if (xhr.readyState === 4) {
    if (xhr.status === 200) {
      // Parsear la respuesta JSON
      const respuesta = JSON.parse(xhr.responseText);

      // Si la respuesta es exitosa, actualizar el número de artículos en el carrito
      if (respuesta.ok) {
        numeroArticulosEnCarrito.innerHTML = respuesta.numero;
      }
    } else {
      console.error('Error en la solicitud. Estado:', xhr.status);
    }
  }
};

// Enviar la solicitud al servidor
xhr.send(formData);
}

    </script>
</body>
</html>
