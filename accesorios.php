<?php include("template/cabecera.php"); ?>
<?php
include("administrador/config/bd.php");

$sentenciaSQL = $conexion->prepare("SELECT * FROM accesorios");
$sentenciaSQL->execute();
$listaaccesorios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach ($listaaccesorios as $accesorio) { ?>
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="./img/<?php echo $accesorio['ImagenAccesorios']; ?>" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $accesorio['NombreAccesorios']; ?></h4>
                <h5 class="card-title">$<?php echo $accesorio['PrecioAccesorios']; ?></h5>
                <form action="./agregarCarrito.php" method="POST">
                    <input type="hidden" name="usuario" value="1">
                    <input type="hidden" name="juegos" value="<?php echo $accesorio['IdAccesorios']; ?>">
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