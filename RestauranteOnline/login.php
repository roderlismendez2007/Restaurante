<?php
    require 'Confi/database.php';
    require 'Confi/confi.php';
    require 'clases/clienteFunciones.php';
    $db = new Database();
    $con = $db->conectar();

    $proceso =isset($_GET['pago']) ?'pago' : 'login';
    
   
    $errors = [];
    if(!empty($_POST))
    {
    
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $proceso = $_POST['proceso'] ?? 'login';
       

        if(esNulo([$usuario, $password, ])) {
            $errors[] = "Debe llenar todos los campos";

        }
        if(count($errors) ==0){
        $errors [] = login($usuario, $password, $con, $proceso);

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
<?php include 'menu.php'; ?>

    <main class="form-login m-auto pt-4">
   <h2>Iniciar sesion</h2>
   <?php mostrarMensajes($errors);?>
   <form class="row g-3" action="login.php"  method="post" autocomplete="off">
      <input type="hidden" name="proceso" value="<?php echo $proceso ?>">
      <div class="form-floating">
         <input class="form-control" type="text" name="usuario" id="usuario" placeholder="usuario" required>
         <label for="usuario">Usuario</label>
      </div>
      <div class="form-floating">
         <input class="form-control" type="password" name="password" id="password" placeholder="password" required>
         <label for="password">Contraseña</label>
      </div>
      <div class="col-12">
         <a href="recupera.php">¿Olvidaste tu contraseña?</a>
      </div>
      <div class="d-grid gap-3 col-12">
         <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
      <div class="col-12">
         ¿No tienes cuenta? <a href="registro.php">Registrate aquí</a>
      </div>
   </form>

</main>



    <script src="scrips/agregar_producto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 

</body>

</html>