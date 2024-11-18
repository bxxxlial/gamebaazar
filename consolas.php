<?php include("template/cabecera.php"); ?>
<?php
include("administrador/config/bd.php");

$sentenciaSQL = $conexion->prepare("SELECT * FROM consolas");
$sentenciaSQL->execute();
$listaconsolas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach ($listaconsolas as $consola) { ?>
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="./img/<?php echo $consola['ImagenConsolas']; ?>" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $consola['NombreConsolas']; ?></h4>
                <h5 class="card-title">$<?php echo $consola['PrecioConsolas']; ?></h5>
                <form action="./agregarCarrito.php" method="POST">
                    <input type="hidden" name="usuario" value="1">
                    <input type="hidden" name="juegos" value="<?php echo $consola['IdConsolas']; ?>">
                    <label for="cantidad">Cantidad</label>
                    <input class="form-control" type="number" name="cantidad">
                    <br>
                    <button type="submit" class="btn btn-primary" role="button">Agregar al carrito</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>


<?php include("template/pie.php"); ?>