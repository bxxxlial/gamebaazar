<?php include("template/cabecera.php"); ?>

<?php
if ($_POST) {
    include("administrador/config/bd.php");
    $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE nombre =:nombre AND password=:pass");
    $sentenciaSQL->bindParam(':nombre', $_POST['nombre']);
    $sentenciaSQL->bindParam(':pass', $_POST['contraseña']);
    $sentenciaSQL->execute();
    $usuario = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
    if ($usuario['nombre'] != "") {
        $_SESSION['nombre'] = "cliente";
        $_SESSION['nombreUsuario'] = $usuario['nombre'];
        $_SESSION['idCliente'] = $usuario['Id'];
        header('Location:index.php');
    } else {
        $mensaje = "Usuario o contraseña erroneo";
    }
}


?>

<div class="container">
        <div class="row">

            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <br /><br /><br />
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <?php if (isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                            <div class="form-group">
                                <label>Usuario:</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Escribe tu usuario">

                            </div>
                            <div class="form-group">
                                <label>Contraseña:</label>
                                <input type="password" class="form-control" name="contraseña" placeholder="Escribe tu contraseña">
                            </div>

                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include("template/pie.php"); ?>