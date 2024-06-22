<?php
require 'Confi/database.php';
require 'Confi/confi.php';

$db = new Database();
$con = $db->conectar();

$errors = [];
if (!empty($_POST)) {

    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (esNulo([$usuario, $password])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        $errors[] = login($usuario, $password, $con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/esp.css">

    <!-- scripts(js) de datatable y css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish_Mexico.json" defer></script>

</head>

<script>
       $(document).ready( function () {
            $('#example').DataTable(
                {
                "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
                }
                }
            );}
            );
</script>



<body>

 <?php include  'header.php'; ?>

 <main>

<h1>Lista de Usuarios</h1>

<div  class="container" >
 <div class="table-responsive">

 <table id="example" class="display responsive nowrap" style="width:100%">
    <thead>
    <tr>
    <th>ID</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>Email</th>
    <th>Teléfono</th>
    <th>DNI</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    <?php
                        // Usando PDO para obtener los datos
                        $sql_productos = $con->prepare("SELECT id,nombres, apellidos, email, telefono, dni FROM clientes");
                        $sql_productos->execute();
                        $result = $sql_productos->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $row) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['nombres']}</td>";
                            echo "<td>{$row['apellidos']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['telefono']}</td>";
                            echo "<td>{$row['dni']}</td>";
                            echo "</tr>";
                        }
                        ?>
</tbody>
</table>

</div>

</div>

</main>
   
    <?php include  'footer.php'; ?> 


</body>

</html>
