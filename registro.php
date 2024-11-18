<?php 
include("template/cabecera.php"); 

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$corr = (isset($_POST['correo'])) ? $_POST['correo'] : "";
$pass = (isset($_POST['password'])) ? $_POST['password'] : "";
$nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


include("administrador/config/bd.php");

switch ($accion) {

    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO usuarios (correo,password,nombre ) VALUES (:corr,:pass,:nombre);");
        $sentenciaSQL->bindParam(':pass', $pass);
        $sentenciaSQL->bindParam(':corr', $corr);
        $sentenciaSQL->bindParam(':nombre', $nom);

        $sentenciaSQL->execute();
        header("Location:inicio.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios");
$sentenciaSQL->execute();
$listaUsuarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="container">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
            Registrar Usuario
            </div>

            <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" required value="<?php echo $nom; ?>" class="form-control" name="nombre" id="nombre" placeholder="Nombre del usuario">
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="text" required value="<?php echo $corr; ?>" class="form-control" name="correo" id="correo" placeholder="Correo del usuario">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" required class="form-control" name="password" id="password" placeholder="Contraseña">
                </div> 
                <br>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                </div>

            </form>
        </div>

    </div>
<?php include("template/pie.php"); ?>