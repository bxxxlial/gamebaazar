<?php include("template/cabecera.php"); ?>
<?php
include("administrador/config/bd.php");

$sentenciaSQL = $conexion->prepare("SELECT * FROM juegos");
$sentenciaSQL->execute();
$listajuegos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach ($listajuegos as $juego) { ?>
    <div class="col-md-3" >
        <div class="card">
            <img class="card-img-top" src="./img/<?php echo $juego['ImagenJuegos']; ?>" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $juego['NombreJuegos']; ?></h4>
                <h5 class="card-title">$<?php echo $juego['PrecioJuegos']; ?></h5>
                <form action="./agregarCarrito.php" method="POST">
                    <input type="hidden" name="usuario" value="1">
                    <input type="hidden" name="juegos" value="<?php echo $juego['IdJuegos']; ?>">
                    <label for="cantidad">Cantidad</label>
                    <input class="form-control" type="number" name="cantidad">
                    <br>
                    <button type="submit" class="btn btn-primary" role="button">Agregar al carrito</button>
                    <br>
                </form>
            </div>
        </div>
    </div>
<?php } ?>


<?php include("template/pie.php"); ?>