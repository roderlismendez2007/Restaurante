<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand mx-auto">
                <strong>shop need</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a href="index.php" class="nav-link active">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="Catalogo.php" class="nav-link">Categorias</a>
                    </li>
                </ul>
                <a href="checkout.php" class="btn btn-primary me-2 btn-sm">
                Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                </a>
                
                <?php if (isset($_SESSION['user_id'])) { ?>

                    <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user"></i><?php echo $_SESSION['user_name']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="compra.php">Mis compras</a></li>
                            <li><a class="dropdown-item" href="Usuario.php">Mis Datos</a></li>
                            <li><a class="dropdown-item" href="logout.php">cerrar sesion</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-success btn-sm">Ingresar</a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
