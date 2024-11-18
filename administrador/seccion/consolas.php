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
            $setenciasSQL =$conexion->prepare("INSERT INTO consolas (NombreConsolas, ImagenConsolas, PrecioConsolas) VALUES (:nombre,:imagen,:precio);");
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

            header("Location:consolas.php");
           break;

        case "Modificar":

            $setenciasSQL =$conexion->prepare("UPDATE consolas SET NombreConsolas=:nombre WHERE IdConsolas=:id");
            $setenciasSQL->bindParam(':nombre',$txtNombre);
            $setenciasSQL->bindParam(':id',$txtID);
            $setenciasSQL->execute();

            $setenciasSQL =$conexion->prepare("UPDATE consolas SET PrecioConsolas=:precio WHERE IdConsolas=:id");
            $setenciasSQL->bindParam(':precio',$txtPrecio);
            $setenciasSQL->bindParam(':id',$txtID);
            $setenciasSQL->execute();
            
            

            if($txtImagen!=""){
            
                $fecha= new DateTime();
                $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $setenciasSQL =$conexion->prepare("SELECT ImagenConsolas FROM consolas WHERE IdConsolas=:id");
                    $setenciasSQL->bindParam(':id',$txtID);
                    $setenciasSQL->execute();
                    $consola=$setenciasSQL->fetch(PDO::FETCH_LAZY);

                    if(isset($consola["ImagenConsolas"])&&($consola["ImagenConsolas"]!="imagen.jpg")){

                        if(file_exists("../../img/".$consola["ImagenConsolas"])){

                            unlink("../../img/".$consola["ImagenConsolas"]);
                        }
                    }


            $setenciasSQL =$conexion->prepare("UPDATE consolas SET ImagenConsolas=:imagen WHERE IdConsolas=:id");
            $setenciasSQL->bindParam(':imagen',$nombreArchivo);
            $setenciasSQL->bindParam(':id',$txtID);
            $setenciasSQL->execute();

            }
            
            header("Location:consolas.php");


            break;

            case "Cancelar":
                
                header("Location:consolas.php");


                break;

                case "Seleccionar":
                   // echo "se";
                    $setenciasSQL =$conexion->prepare("SELECT * FROM consolas WHERE IdConsolas=:id");
                    $setenciasSQL->bindParam(':id',$txtID);
                    $setenciasSQL->execute();
                    $consola=$setenciasSQL->fetch(PDO::FETCH_LAZY);

                    $txtNombre=$consola['NombreConsolas'];
                    $txtImagen=$consola['ImagenConsolas'];
                    $txtPrecio=$consola['PrecioConsolas'];




                    break;
        
                    case "Borrar":

                    $setenciasSQL =$conexion->prepare("SELECT ImagenConsolas FROM consolas WHERE IdConsolas=:id");
                    $setenciasSQL->bindParam(':id',$txtID);
                    $setenciasSQL->execute();
                    $consola=$setenciasSQL->fetch(PDO::FETCH_LAZY);

                    if(isset($consola["ImagenConsolas"])&&($consola["ImagenConsolas"]!="imagen.jpg")){

                        if(file_exists("../../img/".$consola["ImagenConsolas"])){

                            unlink("../../img/".$consola["ImagenConsolas"]);
                        }
                    }

                       $setenciasSQL =$conexion->prepare("DELETE  FROM consolas WHERE IdConsolas=:id");
                       $setenciasSQL->bindParam(':id',$txtID);
                        $setenciasSQL->execute();   
                        header("Location:consolas.php");

                        break;
}
$setenciasSQL =$conexion->prepare("SELECT * FROM consolas");
$setenciasSQL->execute();
$listaConsolas=$setenciasSQL->fetchAll(PDO::FETCH_ASSOC);


?>
     
<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Informacion de consola
        </div>
        <div class="card-body">
            
<form method="POST" enctype="multipart/form-data">


<div class = "form-group">
<label for="txtID">ID:</label>
<input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
</div>

<form>
<div class = "form-group">
<label for="txtNombre">Nombre de la consola:</label>
<input type="text" required class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre" placeholder="Nombre de consola">
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

        <?php foreach($listaConsolas as $consola) { ?>
        <tr>
            <td> <?php echo $consola['IdConsolas'];?></td>
            <td> <?php echo $consola['NombreConsolas'];?></td>
            <td>
                <img class="img-thumbnail rounded" src="../../img/<?php echo $consola['ImagenConsolas'];?>" width="70" alt="">
                 
                
                
                
                
            </td>
            <td> <?php echo $consola['PrecioConsolas'];?></td>
            <td>

            <form method="post">

            <input type="hidden" name="txtID" id="txtID" value=" <?php echo $consola['IdConsolas'];?>">

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