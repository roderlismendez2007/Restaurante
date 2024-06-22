<?php
session_start(); // Inicias la sesión si no lo has hecho aún

require '../Confi/database.php';
require '../Confi/confi.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

// Verificamos si hay una sesión activa
if (!empty($_SESSION['user_cliente'])) {
    // Obtenemos el ID del usuario de la sesión
    $usuario_id = $_SESSION['user_cliente'];

    // Obtenemos los datos enviados por el formulario
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $ubicacion = trim($_POST['ubicacion']);

    // Validamos los datos
    if (empty($email) || empty($telefono) || empty($dni)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    // Si no hay errores, actualizamos los datos del usuario en la base de datos
    if (empty($errors)) {
        $sql_update = $con->prepare("UPDATE clientes SET email = ?, telefono = ?, dni = ?, ubicacion = ? WHERE id = ?");

        $result = $sql_update->execute([$email, $telefono, $dni,$ubicacion, $usuario_id]);

        if ($result) {
            // Datos actualizados correctamente
            $_SESSION['success_message'] = "Los datos se han actualizado correctamente.";
        } else {
            $errors[] = "Hubo un error al actualizar los datos. Por favor, inténtalo de nuevo.";
        }
    }

} else {
    // Si no hay sesión activa, redirigimos al usuario a la página de inicio de sesión
    header("Location: inicio_sesion.php");
    exit; // Terminamos la ejecución del script después de redirigir
}

// Redirigimos de vuelta a la página de edición con los posibles errores o mensajes de éxito
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
} 

header("Location: ../EditarUsuario.php");
exit;
