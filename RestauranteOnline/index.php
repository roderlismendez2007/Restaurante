<?php

require 'Confi/database.php';
require 'Confi/confi.php';
$db = new Database();
$con = $db->conectar();

// Consulta SQL para obtener todas las categorías distintas de los productos excluyendo "Productos de emprendimiento"
$sql_categorias = $con->prepare("SELECT DISTINCT categoria FROM productos WHERE active=1 AND categoria != 'Productos de emprendimiento'");
$sql_categorias->execute();
$categorias = $sql_categorias->fetchAll(PDO::FETCH_COLUMN);

// Consulta SQL para obtener todos los productos ordenados por categoría excluyendo "Productos de emprendimiento"
$sql_productos = $con->prepare("SELECT id, nombre, precio, categoria FROM productos WHERE active=1 AND categoria != 'Productos de emprendimiento' ORDER BY RAND()");
$sql_productos->execute();
$sql_productos1 = $con->prepare("SELECT id, nombre, precio, categoria FROM productos WHERE active=1 AND categoria != 'Productos de emprendimiento' ORDER BY RAND()");
$sql_productos1->execute();
$resultado = $sql_productos->fetchAll(PDO::FETCH_ASSOC);
$resultado1 = $sql_productos1->fetchAll(PDO::FETCH_ASSOC);

// Obtener hasta cinco productos aleatorios excluyendo "Productos de emprendimiento"
$productos_aleatorios = array_slice($resultado, 0, 5);
$productos_aleatorios1 = array_slice($resultado1, 0, 6);

// Creamos un array asociativo para agrupar los productos restantes por categoría excluyendo "Productos de emprendimiento"
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
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
        
        <div class="my-4">
            <div class="row row-cols-1 row-cols-md-5 g-3">
                <?php foreach ($productos_aleatorios as $index => $producto) : ?>
                    <div class="col position-relative">
                        <div class="card shadow-sm animate__animated animate__fadeIn" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                            <?php 
                                $id = $producto['id'];
                                $imagen = "imagenes/productos/" . $id . "/principal.jpg";

                                if (!file_exists($imagen)){
                                    $imagen = "imagenes/f2.avif";
                                }
                            ?>
                            <img src="<?php echo $imagen; ?>" class="card-img-top rounded img32">
                            <div class="overlay">
                                <div class="text-overlay">
                                    <?php echo $producto['nombre']; ?>
                                </div>
                                <div class="btn-group btn-overlay">
                                    <a href="detalles.php?id=<?php echo $producto['id']; ?>&token=<?php echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="my-4">
            <h2 class="display-4 text-center mb-4">Algunos Productos</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($productos_aleatorios1 as $index => $producto) : ?>
                    <div class="col">
                        <div class="card shadow-sm animate__animated animate__fadeInUp" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                            <?php 
                                $id = $producto['id'];
                                $imagen = "imagenes/productos/" . $id . "/principal.jpg";

                                if (!file_exists($imagen)){
                                    $imagen = "imagenes/f2.avif";
                                }
                            ?>
                            <img src="<?php echo $imagen; ?>" class="card-img-top rounded">
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
        <h1 class="display-4 text-center mb-4"><a href="Catalogo.php" class="btn btn-success btn-sm">Ver más</a></h1>
        
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
    <script>
        function mostrarNotificacion(nombreProducto) {
            const notificacion = document.createElement('div');
            notificacion.classList.add('notification', 'alert', 'alert-success');
            notificacion.innerHTML = `
                <strong>Producto agregado:</strong> ${nombreProducto}
            `;
            document.body.appendChild(notificacion);
            setTimeout(() => {
                notificacion.remove();
            }, 1000);
        }

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
