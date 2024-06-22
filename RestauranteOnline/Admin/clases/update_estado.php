<?php
require '../Confi/database.php';
require '../Confi/confi.php';

$db = new Database();
$con = $db->conectar();

$response = ['success' => false];

try {
    if (isset($_POST['id']) && isset($_POST['estado'])) {
        $id = $_POST['id'];
        $estado = $_POST['estado'];

        $sql_update = $con->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        $sql_update->execute([$estado, $id]);

        if ($sql_update->rowCount() > 0) {
            $response['success'] = true;
        }
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Set the Content-Type to application/json
header('Content-Type: application/json');
echo json_encode($response);
?>
