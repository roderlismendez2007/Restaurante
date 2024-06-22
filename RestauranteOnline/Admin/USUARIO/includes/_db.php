<?php
require '../Confi/database.php';
require '../Confi/confi.php';
    $db = new Database();
    $conexion = $db->conectar();

if(!$conexion){
echo "No se realizo la conexion a la basa de datos, el error fue:".
mysqli_connect_error() ;

}

?>

<!--Echo por Roderlis mendez valdez estudiante del politecnico nuestra señora de la esperanza -->
