<?php
    require 'Confi/database.php';
    require 'Confi/confi.php';
    require 'clases/clienteFunciones.php';
    $db = new Database();
    $con = $db->conectar();

   
    $errors = [];
    if(!empty($_POST))
    {
    
        $nombres = trim($_POST['nombres']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);
        $dni = trim($_POST['dni']);
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);
        $ubicacion = trim($_POST['ubicacion']);

        if(esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword,$ubicacion ])) {
            $errors[] = "Debe llenar todos los campos";

        }
        if (!esEmail($email)) {
            $errors[] = "La dereccion de correo no es valida";

        }
        if(!validaPassword($password, $repassword)){
        $errors[] = "Las ontraseñas no coinciden";
        }
        if(usuarioExiste($usuario, $con)){
            $errors[]="el nombre de usuario $usuario ya existe";
        }
        if(emailExiste($email, $con)){
            $errors[]="el correo electronico $email ya existe";
        }
    if(count($errors) ==0){

    
        $id = registrarcliente([$nombres, $apellidos, $email, $telefono, $dni, $ubicacion], $con);
        if ($id > 0){
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $token = generartoken();
            if (registraUsuario([$usuario, $pass_hash, $token, $id], $con)){
                $error[] = "Error al registrar Usuario";
            }
        

        }
        else{
            $error[] = "Error al registrar cliente";
        }
    }

     }
    
    
        //session_destroy();
    
        
    ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante Online</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.php'; ?>
<!-- La parte del registro para que sepan por qué el vago de Josué no puso comentarios -->
<div class="container">
    <h2>Datos del cliente</h2>
    <?php mostrarMensajes($errors); ?>

    <form class="row g-3" action="registro.php" method="post" autocomplete="off">
        <div class="col-md-6">
            <label for="nombres"><span class="text-danger">*</span> Nombres</label>
            <input type="text" name="nombres" id="nombres" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="email"><span class="text-danger">*</span> Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="telefono"><span class="text-danger">*</span> Teléfono</label>
            <input type="tel" name="telefono" id="telefono" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="dni"><span class="text-danger">*</span> DNI o Cédula</label>
            <input type="text" name="dni" id="dni" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="ubicacion"><span class="text-danger">*</span> Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="usuario"><span class="text-danger">*</span> Usuario</label>
            <input type="text" name="usuario" id="usuario" class="form-control" required>
            <span id="validarUsuario" class="text-danger"></span>
        </div>
        <div class="col-md-6">
            <label for="password"><span class="text-danger">*</span> Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="repassword"><span class="text-danger">*</span> Repetir contraseña</label>
            <input type="password" name="repassword" id="repassword" class="form-control" required>
        </div>
        <div class="col-12">
            <i><b>Nota:</b> los campos con asteriscos son obligatorios</i>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
</div>




    <script src="scrips/agregar_producto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
<script>
let txtUsuario = document.getElementByid('usuario')
txtUsuario.addEventListener("blur", function(){
    existeUsuario(txtUsuario.value)
}, false)

let txtEmail = document.getElementByid('email')
txtEmail.addEventListener("blur", function(){
    existeEmail(txtEmail.value)
}, false)


function existeEmail(email){
    let url = "clases/clienteAjax.php"
    let formData = new FormData()
    formData.append("action","existeEmail")
    formData.append("email", email)
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json())
    .then(data => {

        if(data.ok){
            document.getElementById('email').value = ''
            document.getElementById('validaEmail').innerHTML = 'Email no disponible'
        }else{
            document.getElementById('validaEmail').innerHTML = ''
        }

    })

}

function existeUsuario(usuario){
    let url = "clases/clienteAjax.php"
    let formData = new FormData()
    formData.append("action","existeUsuario")
    formData.append("usuario", usuario)
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json())
    .then(data => {

        if(data.ok){
            document.getElementById('usuario').value = ''
            document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
        }else{
            document.getElementById('validaUsuario').innerHTML = ''
        }

    })
}

</script>

</body>

</html>