<?php
require '../Confi/database.php';
require '../Confi/confi.php';

$db = new Database();
$conexion = $db->conectar();

if(isset($_POST['registrar'])) {

  if(strlen($_POST['nombre']) >= 1 && strlen($_POST['password']) >= 1 && strlen($_POST['rol']) >= 1) {

      $nombre = trim($_POST['nombre']);
      $password = trim($_POST['password']);
      $rol = trim($_POST['rol']);

      $consulta = "INSERT INTO user (nombre, password, rol) VALUES (:nombre, :password, :rol)";

      $stmt = $conexion->prepare($consulta);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':rol', $rol);

      if($stmt->execute()) {
          header('Location: ../views/user.php');
      } else {
          echo "Error al registrar el usuario.";
      }

      // Cerramos la conexión al final
      $conexion = null;
  }
}









?>

<!--Echo por Roderlis mendez valdez estudiante del politecnico nuestra señora de la esperanza -->
