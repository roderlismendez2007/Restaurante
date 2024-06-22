<?php
   
   require '../Confi/database.php';
   require '../Confi/confi.php';
   if(isset($_GET['Eliminar'])){
    $Eliminar = $_GET['Eliminar'];
   }else{
    $Eliminar = 0;
   }
if($Eliminar <= 0){
    if (isset($_POST['accion'])){ 
        switch ($_POST['accion']){
            //casos de registros
            case 'editar_registro':
                editar_registro();
                break; 
    
                case 'user.php';
                eliminar_registro();
        
                break;
    
                case 'acceso_user';
                acceso_user();
                break;
    
    
            }
    
        }
}else{
    eliminar_registro();
}

    function editar_registro() {
        $db = new Database();
        $conexion = $db->conectar();

		extract($_POST);
        
        $sql_update = "UPDATE user SET nombre = :nombre, password = :password, rol = :rol WHERE id = :id";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bindParam(':nombre', $nombre);
        $stmt_update->bindParam(':password', $password);
        $stmt_update->bindParam(':rol', $rol);
        $stmt_update->bindParam(':id', $id);
        $stmt_update->execute();


		header('Location: ../views/user.php');

}

function eliminar_registro() {
    $db = new Database();
    $conexion = $db->conectar();
    $id = $_GET['id'];

    $sql_delete = "DELETE FROM user WHERE id = :id";
    $stmt_delete = $conexion->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id);
    $stmt_delete->execute();

    header('Location: ../views/user.php');


}

function acceso_user() {
    $nombre=$_POST['nombre'];
    $password=$_POST['password'];
    session_start();
    $_SESSION['nombre']=$nombre;

    $db = new Database();
    $conexion = $db->conectar();

    $consulta = $conexion->prepare("SELECT * FROM user WHERE nombre = :nombre AND password = :password");
$consulta->bindParam(':nombre', $nombre);
$consulta->bindParam(':password', $password);
$consulta->execute();

$filas = $consulta->fetch(PDO::FETCH_ASSOC);

if ($filas) {
    if ($filas['rol'] == 1) { //admin
        header('Location: ../views/user.php');
        
    } else if ($filas['rol'] == 2) { //lector
        header('Location:/restauranteonline/Admin/Usuarios.php');
    } else {
        header('Location: login.php');
        session_destroy();
    }
} else {
    echo "Usuario o contraseña incorrectos";
}

  
}

?>


<!--Echo por Roderlis mendez valdez estudiante del politecnico nuestra señora de la esperanza -->







