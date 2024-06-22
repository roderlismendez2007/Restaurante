<?php
require 'Confi/database.php';
require 'Confi/confi.php';

try {
    $db = new Database();
    $con = $db->conectar();

    // Consulta para productos más comprados
    $sql_mas_comprados = "SELECT 
                            id_producto, 
                            nombre, 
                            SUM(cantidad) AS total_cantidad
                          FROM 
                            detalle_compra
                          GROUP BY 
                            id_producto, nombre
                          ORDER BY 
                            total_cantidad DESC";
    $stmt_mas_comprados = $con->prepare($sql_mas_comprados);
    $stmt_mas_comprados->execute();
    $productos_mas_comprados = $stmt_mas_comprados->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para productos más frecuentemente comprados
    $sql_mas_repetidos = "SELECT 
                            id_producto, 
                            nombre, 
                            COUNT(id_producto) AS total_repeticiones
                          FROM 
                            detalle_compra
                          GROUP BY 
                            id_producto, nombre
                          ORDER BY 
                            total_repeticiones DESC";
    $stmt_mas_repetidos = $con->prepare($sql_mas_repetidos);
    $stmt_mas_repetidos->execute();
    $productos_mas_repetidos = $stmt_mas_repetidos->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para productos que más dinero generan
    $sql_mas_dinero = "SELECT 
                        dc.id_producto, 
                        productos.nombre, 
                        SUM(dc.cantidad * productos.precio) AS total_dinero
                      FROM 
                        detalle_compra dc
                      JOIN 
                        productos ON dc.id_producto = productos.id
                      GROUP BY 
                        dc.id_producto, productos.nombre
                      ORDER BY 
                        total_dinero DESC";
    $stmt_mas_dinero = $con->prepare($sql_mas_dinero);
    $stmt_mas_dinero->execute();
    $productos_mas_dinero = $stmt_mas_dinero->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

// Preparar los datos para los gráficos
$productos_comprados = [];
$cantidades = [];
foreach ($productos_mas_comprados as $producto) {
    $productos_comprados[] = $producto['nombre'];
    $cantidades[] = $producto['total_cantidad'];
}

$productos_repetidos = [];
$repeticiones = [];
foreach ($productos_mas_repetidos as $producto) {
    $productos_repetidos[] = $producto['nombre'];
    $repeticiones[] = $producto['total_repeticiones'];
}

$productos_dinero = [];
$dinero = [];
foreach ($productos_mas_dinero as $producto) {
    $productos_dinero[] = $producto['nombre'];
    $dinero[] = $producto['total_dinero'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Más Comprados y Frecuentemente Comprados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h1>Bienvenido</h1>
    <h1 class="mt-5">Productos Más Comprados</h1>

    <div class="row">
        <div class="col-md-6">
            <canvas id="productosCompradosChart"></canvas>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Total Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_mas_comprados as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['total_cantidad']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <h1 class="mt-5">Productos Más Frecuentemente Comprados</h1>

    <div class="row">
        <div class="col-md-6">
            <canvas id="productosRepetidosChart"></canvas>
        </div>
        <div class="col-md-6">
            <table id="example" class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Total Repeticiones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_mas_repetidos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['total_repeticiones']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <h1 class="mt-5">Productos que Más Dinero Generan</h1>

    <div class="row">
        <div class="col-md-6">
            <canvas id="productosDineroChart"></canvas>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Total Dinero</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_mas_dinero as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo Moneda . '$' . htmlspecialchars($producto['total_dinero']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctxComprados = document.getElementById('productosCompradosChart').getContext('2d');
        var productosCompradosChart = new Chart(ctxComprados, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($productos_comprados); ?>,
                datasets: [{
                    label: 'Total Cantidad',
                    data: <?php echo json_encode($cantidades); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                return label;
                            }
                        }
                    }
                }
            }
        });

        var ctxRepetidos = document.getElementById('productosRepetidosChart').getContext('2d');
        var productosRepetidosChart = new Chart(ctxRepetidos, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($productos_repetidos); ?>,
                datasets: [{
                    label: 'Total Repeticiones',
                    data: <?php echo json_encode($repeticiones); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                return label;
                            }
                        }
                    }
                }
            }
        });

        var ctxDinero = document.getElementById('productosDineroChart').getContext('2d');
        var productosDineroChart = new Chart(ctxDinero, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($productos_dinero); ?>,
                datasets: [{
                    label: 'Total Dinero',
                    data: <?php echo json_encode($dinero); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': $';
                                }
                                label += context.raw.toFixed(2);
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>
