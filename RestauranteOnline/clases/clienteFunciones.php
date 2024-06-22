<?php
/*codigo de la funcion de la conecion de registro*/
/*la fucnion que eta en regitro.php*/
function esNulo(array $parametos){
    foreach($parametos as $parametos){
    if(strlen(trim($parametos)) < 1){
        return true;
    }

    } 
    return false;
}
function esEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}
function validaPassword($password, $repassword){

    if(strcmp($password, $repassword) === 0){
        return true;

    }
    return false;

}
function generartoken()
{
return md5(uniqid(mt_rand(), false));
}

/*la fucnion que eta en regitro.php*/function registrarcliente(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, fecha_alta, ubicacion) VALUES(?,?,?,?,?, now(),? )");

   if($sql->execute($datos)) {
   return $con->lastInsertId();
   }
   return 0;
}


/*la fucnion que eta en regitro.php*/
function registraUsuario(array $datos, $con){
    $sql = $con->prepare("INSERT INTO usuario (usuario, password, token, id_cliente ) VALUES (?,?,?,?)");

    if ($sql->execute($datos)) {
        return true;

    }
return false;
}

function usuarioExiste($usuario, $con){
    $sql = $con->prepare("SELECT id FROM usuario WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
      if($sql ->fetchColumn() > 0){
        return true;
      }
      return false;
}

function emailExiste($email, $con){
    $sql = $con->prepare("SELECT id FROM clientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
      if($sql ->fetchColumn() > 0){
        return true;
      }
      return false;
}
function mostrarMensajes(array $errors){
    if(count($errors) > 0){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        foreach($errors as $error){
echo '<li>'. $error.'</i>';
        }
        echo '<ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

        
  
    }

    }


    //intento de activar el login//

    function activarUsuario($id, $con)
{
    $sql = $con->prepare("UPDATE usuario SET activacion = 0, toke = '' WHERE id = ?");
    return $sql->execute([$id]);
} // Falta cerrar la llave de la función activarUsuario

function login($usuario, $password, $con, $proceso)
{
 

    // Primero, intentamos encontrar al usuario en la tabla "user"
    $sql = $con->prepare("SELECT id, nombre, password, rol FROM user WHERE nombre LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verificar la contraseña
        if ($password == $row['password']) {
            // Establecer las variables de sesión
            $_SESSION['nombre'] = $usuario;

            // Redirigir según el proceso
            if ($row["rol"] == 2) {
                header("Location: Admin/Usuarios.php");
            } else {
                header("Location: Admin/USUARIO/views/user.php");
            }
            exit;
        } else {

        }
    }

    // Si no encontramos el usuario en la tabla "user", intentamos en la tabla "usuario"
    $sql = $con->prepare("SELECT id, usuario, password, id_cliente FROM usuario WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Establecer las variables de sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['usuario'];
            $_SESSION['user_cliente'] = $row['id_cliente'];

            // Redirigir según el proceso
            if ($proceso == 'pago') {
                header("Location: checkout.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            return 'El usuario y/o contraseña son incorrectos.';
        }
    }

    // Si no se encuentra al usuario en ninguna tabla
    return 'El usuario y/o contraseña son incorrectos.';
}

        



    