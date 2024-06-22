<?php 

require '../Confi/database.php';
require '../Confi/confi.php';
require 'clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$token = generarToken();
$_SESSION['token'] = $token;
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if(is_array($datos)){

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $_SESSION['user_cliente'];
    $sql = $con->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
    $id = $con->lastInsertId();
    $ListaP = "";
    $Total = 0;
    if($id > 0){
        
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {

            foreach ($productos as $clave => $cantidad) {
        
                $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad as cantidad FROM productos WHERE id=? AND active=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];

                $precio_desc = $precio * (1 - ($descuento / 100));
                $Total += $precio_desc * $cantidad;

                $sql_cliente = $con->prepare("SELECT ubicacion FROM clientes WHERE id=?");
                $sql_cliente->execute([$id_cliente]);
                $row_cliente = $sql_cliente->fetch(PDO::FETCH_ASSOC);

                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?, ?, ?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);

                $dato = $row_prod['nombre'] . "x" . $cantidad . " (" . Moneda . "$" . $precio_desc * $cantidad . ")";
                $ListaP .= $dato ."\n";
            }

            $sql_insert2 = $con->prepare("INSERT INTO pedidos (id_cliente, productos, precio, fecha, ubicacion, estado) VALUES (?,?, ?, ?, ?, ?)");
            $sql_insert2->execute([$id_cliente, $ListaP, $Total, $fecha_nueva, $row_cliente['ubicacion'], 0]);

            // Verificar errores antes de la redirección
            if(headers_sent($filename, $linenum)) {
                echo "Headers already sent in $filename on line $linenum";
                exit;
            } else {
                header("Location: compra_dalle.php?orden=$id_transaccion&token=$token");
                exit;
            }
        }
        unset($_SESSION['carrito']);
    }

}
?>
