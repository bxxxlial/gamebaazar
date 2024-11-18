<?php
session_start();
if (isset($_SESSION['nombre'])) {
    if ($_SESSION['nombre'] == "cliente") {
        $nombreUsuario = $_SESSION["nombreUsuario"];
    }else{
        $_SESSION['mensaje'] = "Se requiere ser cliente para poder iniciar sesión";
    }
}
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>GameBazaar</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
 </head>
 <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<ul class="nav navbar-nav w-100">
			<li class="nav-item">
                <a class="nav-link" href="index.php">GameBazaar</a>
            </li>
            <?php if(isset($nombreUsuario)){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="historialCarrito.php">Historial de Compras</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="nosotros.php">Nosotros</a>
            </li>
            <?php if(!isset($nombreUsuario)){ ?>
                <li class="nav-item">
                    <a class="nav-link ms-auto" href="inicio.php">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ms-auto" href="registro.php">Registrarte</a>
                </li>
            <?php } else {?>
                <li class="nav-item ms-auto">
                    <span class="navbar-text"> <?php echo($nombreUsuario); ?>&nbsp;&nbsp;<a href="cerrar.php">Cerrar Sesión</a></span>
                </li>
            <?php }?>
        </ul>
        </div>
    </nav>
    <div class="container">
        <br /><br />
        <div class="row">