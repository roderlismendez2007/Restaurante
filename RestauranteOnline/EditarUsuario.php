<?php
require 'Confi/database.php';
require 'Confi/confi.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

// Verificamos si hay una sesión activa
if (!empty($_SESSION['user_cliente'])) {
    // Obtenemos el ID del usuario de la sesión
    $usuario_id = $_SESSION['user_cliente'];

    // Preparamos la consulta para obtener los datos del usuario actual
    $sql_usuario = $con->prepare("SELECT nombres, apellidos, email, telefono, dni, ubicacion FROM clientes WHERE id = ?");
    $sql_usuario->execute([$usuario_id]);
    $usuario = $sql_usuario->fetch(PDO::FETCH_ASSOC);
} else {
    // Si no hay sesión activa, redirigimos al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit; // Terminamos la ejecución del script después de redirigir
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/estilo.css" rel="stylesheet">
    <style>
        .card {
            margin-top: 50px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-header {
            background-color: #343a40;
            color: white;
        }

        .card-title {
            margin-bottom: 0;
        }

        .card-body p {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <?php include 'menu.php'; ?>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center">Editar Usuario</h5>
            </div>
            <div class="card-body">
                <form action="clases/guardar_datos_usuario.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $usuario['dni']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $usuario['ubicacion']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
            <a href="Usuario.php" class="btn btn-secondary">Volver</a>
        </div>
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
