<?php include("../template/cabecera.php");?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){

    case "Agregar":
            $setenciasSQL =$conexion->prepare("INSERT INTO juegos (NombreJuegos, ImagenJuegos, PrecioJuegos) VALUES (:nombre,:imagen,:precio);");
            $setenciasSQL->bindParam(':nombre',$txtNombre);

            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            
            if($tmpImagen!=""){

                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }

            $setenciasSQL->bindParam(':imagen',$nombreArchivo);
            $setenciasSQL->bindParam(':precio',$txtPrecio);
            $setenciasSQL->execute();

            header("Location:productos.php");
           break;

        case "Modificar":

            $setenciasSQL =$conexion->prepare("UPDATE juegos SET NombreJuegos=:nombre WHERE IdJuegos=:id");
            $setenciasSQL->bindParam(':nombre',$txtNombre);
            $setenciasSQL->bindParam(':id',$txtID);
            $setenciasSQL->execute();

            $setenciasSQL =$conexion->prepare("UPDATE juegos SET PrecioJuegos=:precio WHERE IdJuegos=:id");
            $setenciasSQL->bindParam(':precio',$txtPrecio);
            $setenciasSQL->bindParam(':id',$txtID);
            $setenciasSQL->execute();
            
            

            if($txtImagen!=""){
            
                $fecha= new DateTime();
                $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $setenciasSQL =$conexion->prepare("SELECT ImagenJuegos FROM juegos WHERE IdJuegos=:id");
                    $setenciasSQL->bindParam(':id',$txtID);
                    $setenciasSQL->execute();
                    $juego=$setenciasSQL->fetch(PDO::FETCH_LAZY);

                    if(isset($juego["ImagenJuegos"])&&($juego["ImagenJuegos"]!="imagen.jpg")){

                        if(file_exists("../../img/".$juego["ImagenJuegos"])){

                            unlink("../../img/".$juego["ImagenJuegos"]);
                        }
                    }


            $setenciasSQL =$conexion->prepare("UPDATE juegos SET ImagenJuegos=:imagen WHERE IdJuegos=:id");
            $setenciasSQL->bindParam(':imagen',$nombreArchivo);
            $setenciasSQL->bindParam(':id',$txtID);
            $setenciasSQL->execute();

            }
            
            header("Location:productos.php");


            break;

            case "Cancelar":
                
                header("Location:productos.php");


                break;

                case "Seleccionar":
                   // echo "se";
                    $setenciasSQL =$conexion->prepare("SELECT * FROM juegos WHERE IdJuegos=:id");
                    $setenciasSQL->bindParam(':id',$txtID);
                    $setenciasSQL->execute();
                    $juego=$setenciasSQL->fetch(PDO::FETCH_LAZY);

                    $txtNombre=$juego['NombreJuegos'];
                    $txtImagen=$juego['ImagenJuegos'];
                    $txtPrecio=$juego['PrecioJuegos'];




                    break;
        
                    case "Borrar":

                    $setenciasSQL =$conexion->prepare("SELECT ImagenJuegos FROM juegos WHERE IdJuegos=:id");
                    $setenciasSQL->bindParam(':id',$txtID);
                    $setenciasSQL->execute();
                    $juego=$setenciasSQL->fetch(PDO::FETCH_LAZY);

                    if(isset($juego["ImagenJuegos"])&&($juego["ImagenJuegos"]!="imagen.jpg")){

                        if(file_exists("../../img/".$juego["ImagenJuegos"])){

                            unlink("../../img/".$juego["ImagenJuegos"]);
                        }
                    }

                       $setenciasSQL =$conexion->prepare("DELETE  FROM juegos WHERE IdJuegos=:id");
                       $setenciasSQL->bindParam(':id',$txtID);
                        $setenciasSQL->execute();   
                        header("Location:productos.php");

                        break;
}
$setenciasSQL =$conexion->prepare("SELECT * FROM juegos");
$setenciasSQL->execute();
$listaJuegos=$setenciasSQL->fetchAll(PDO::FETCH_ASSOC);


?>
     
<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Informacion de juego
        </div>
        <div class="card-body">
            
<form method="POST" enctype="multipart/form-data">


<div class = "form-group">
<label for="txtID">ID:</label>
<input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
</div>

<form>
<div class = "form-group">
<label for="txtNombre">Nombre del videojuego:</label>
<input type="text" required class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre" placeholder="Nombre del juego">
</div>

<form>
<div class = "form-group">
<label for="txtImagen">Imagen:</label>
<br/>

<?php 
 if($txtImagen!="") { ?>
        
        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="70" alt="">

<?php  } ?>


<input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
</div>

<form>
<div class = "form-group">
<label for="txtPrecio">Precio:</label>
<input type="text" required class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" id="txtPrecio" placeholder="Precio">
</div>


<div class="btn-group" role="group" aria-label="">
    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")? "disabled":"";?> value="Agregar" class="btn btn-success"> Agregar</button>
    <button type="submit" name="accion"  <?php echo ($accion!=="Seleccionar")? "disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="submit" name="accion"  <?php echo ($accion!=="Seleccionar")? "disabled":"";?> value="Cancelar" class="btn btn-info"> Cancelar</button>
</div>


</form>
        </div>
       
    </div>



</div>

<div class="col-md-7">
    
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach($listaJuegos as $juego) { ?>
        <tr>
            <td> <?php echo $juego['IdJuegos'];?></td>
            <td> <?php echo $juego['NombreJuegos'];?></td>
            <td>
                <img class="img-thumbnail rounded" src="../../img/<?php echo $juego['ImagenJuegos'];?>" width="70" alt="">
                 
                
                
                
                
            </td>
            <td> <?php echo $juego['PrecioJuegos'];?></td>
            <td>

            <form method="post">

            <input type="hidden" name="txtID" id="txtID" value=" <?php echo $juego['IdJuegos'];?>">

            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">



            </form>
            </td>
        </tr>

        <?php }   ?>
    </tbody>
</table>




</div>



<?php include("../template/pie.php")?>