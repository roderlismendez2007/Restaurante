<?php
require 'Confi/database.php';
require 'Confi/confi.php';

$db = new Database();
$con = $db->conectar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/esp.css">

    <!-- scripts(js) de datatable y css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish_Mexico.json" defer></script>

    <style>
        .productos-completo {
            display: none;
        }

        /* Styles for switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(14px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

<main>

<h1>Lista de Pedidos</h1>

<div class="container">
    <div class="table-responsive">

        <table id="example" class="display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>id cliente</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Ubicacion del pedido</th>
                    <th>Fecha del pedido</th>
                    <th>Envio</th>
                </tr>
            </thead>
            <tbody id="tableBody">
            <?php
                $sql_productos = $con->prepare("SELECT * FROM pedidos");
                $sql_productos->execute();
                $result = $sql_productos->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $productos = htmlspecialchars($row['productos']);
                    $productos_corto = substr($productos, 0, 50);
                    $productos_corto .= strlen($productos) > 50 ? '...' : '';
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['id_cliente']) . "</td>";
                    echo "<td>
                            <span class='productos-corto'>" . $productos_corto . "</span>
                            <span class='productos-completo'>" . nl2br($productos) . "</span>
                            <button class='ver-mas-btn btn btn-link link-success'>Ver más</button>
                          </td>";
                    echo "<td>" . Moneda . "$" . htmlspecialchars($row['precio']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ubicacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                    echo "<td>"
                        . "<label class='switch'>"
                        . "<input type='checkbox' class='estado-checkbox' data-id='" . htmlspecialchars($row['id']) . "' name='estado' value='1'" . ($row['estado'] > 0 ? " checked" : "") . ">"
                        . "<span class='slider round'></span>"
                        . "</label>"
                        . "</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>

    </div>
</div>

</main>
   
<?php include 'footer.php'; ?> 

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });

        $('.ver-mas-btn').on('click', function() {
            var $this = $(this);
            var $productosCompleto = $this.siblings('.productos-completo');
            var $productosCorto = $this.siblings('.productos-corto');
            
            if ($productosCompleto.is(':visible')) {
                $productosCompleto.hide();
                $productosCorto.show();
                $this.text('Ver más');
            } else {
                $productosCompleto.show();
                $productosCorto.hide();
                $this.text('Ver menos');
            }
        });

        // AJAX request for changing estado
        $('.estado-checkbox').on('change', function() {
            var checkbox = $(this);
            var estado = checkbox.is(':checked') ? 1 : 0;
            var id = checkbox.data('id');

            $.ajax({
                url: 'clases/update_estado.php',
                type: 'POST',
                data: {
                    id: id,
                    estado: estado
                },
                success: function(response) {
                    try {
                        var result = JSON.parse(response);
                        if (result.success) {
                            console.log('Estado updated successfully');
                        } else {
                            console.error('Failed to update estado', result.error);
                        }
                    } catch (e) {
                        console.error('Invalid JSON response', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error in AJAX request', error);
                }
            });
        });
    });
</script>


</body>

</html>
