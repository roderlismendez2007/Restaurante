<?php
    require 'Confi/database.php';
    require 'Confi/confi.php';
    require 'clases/clienteFunciones.php';
    $db = new Database();
    $con = $db->conectar();

   
    $errors = [];
    if(!empty($_POST))
    {
    
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        if(esNulo([$usuario, $password, ])) {
            $errors[] = "Debe llenar todos los campos";

        }
        if(count($errors) ==0){
        $errors [] = login($usuario, $password, $con);

        }

        }
        
        
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

    <main class="">
     

    </main>



    <script src="scrips/agregar_producto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 

</body>

</html>