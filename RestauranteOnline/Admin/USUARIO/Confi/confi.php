<?php

define("CLIENT_ID", "AVzYxmA-pk-T0cNNw2ZH4qapObj9fdqvhCjNpsJNfaTZIjew8s1ue4adVqJPRwJz2ie6WtMZySljucjQ");
define("CURREMCY", "RD");
define("KEY_TOKEN", "32x.H-031");
define("Moneda", "RD");


$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart  = count($_SESSION['carrito']['productos']);
}
?>
