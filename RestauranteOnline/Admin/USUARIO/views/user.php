<?php
require '../Confi/database.php';
require '../Confi/confi.php';

$db = new Database();
$conexion = $db->conectar();
session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if ($validar == null || $validar == '') {
    header("Location: ../includes/login.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/es.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Usuarios</title>
</head>
<body>


<div class="container is-fluid">
    <h1 id="titu">Bienvenido</h1>
    <div class="col-xs-12">
        <h1 class="o">Administrador <?php echo $_SESSION['nombre']; ?></h1>
        <br>
        <h2>Lista de usuarios</h2>
        <br>
        <div>
            <a class="btn btn-success" href="../index.php">Nuevo usuario</a>
            <a class="btn btn-warning" href="../../../login.php">Iniciar sesión</a>
        </div>
        <br>
        <br>
        <table class="table table-striped table-dark" id="table_id">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

<?php
$sql = "SELECT id, nombre, password, rol FROM user";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($users) > 0) {
    foreach ($users as $fila) {
        echo "<tr>
                <td>{$fila['nombre']}</td>
                <td>{$fila['password']}</td>
                <td>{$fila['rol']}</td>
                <td>
                    <a class='btn btn-warning' href='editar_user.php?id={$fila['id']}'>Editar</a>
                    <a class='btn btn-danger' href='../includes/_functions.php?Eliminar=1&id={$fila['id']}'>Eliminar</a>

              
                </td>
              </tr>";
    }
} else {
    echo "<tr class='text-center'>
            <td colspan='4'>No existen registros</td>
          </tr>";
}
?>

<!-- Modal para eliminar -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar el usuario?
      </div>
      <div class="modal-footer">
        <form action="../includes/_functions.php?Eliminar=1" method="post" id="deleteForm">
          <input type="hidden" name="id" id="deleteId" value="">
          <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


            </tbody>
        </table>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script src="../js/user.js"></script>
        <script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var userId = button.data('id') // Extraer la información de atributos de datos
        var modal = $(this)
        modal.find('.modal-body #deleteId').val(userId)
    })
</script>

    </div>
</div>
</body>
</html>

