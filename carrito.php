<?php include("template/cabecera.php"); 

  include("administrador/config/bd.php");

  $sentenciaSQL = $conexion->prepare("SELECT c.*,j.NombreJuegos,j.PrecioJuegos,j.ImagenJuegos FROM carrito AS c JOIN juegos AS j ON j.IdJuegos = c.juegos_id WHERE c.usuario_id=:id AND c.estado = '1'");
  $sentenciaSQL->bindParam(':id', $_SESSION['idCliente']);
  $sentenciaSQL->execute();
  $carrito = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

  $sentenciaSQL = $conexion->prepare("SELECT c1.*,a.NombreAccesorios,a.PrecioAccesorios,a.ImagenAccesorios FROM carrito AS c1 JOIN accesorios AS a ON a.IdAccesorios = c1.juegos_id WHERE c1.usuario_id=:id AND c1.estado = '1'");
  $sentenciaSQL->bindParam(':id', $_SESSION['idCliente']);
  $sentenciaSQL->execute();
  $carrito1 = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

  $sentenciaSQL = $conexion->prepare("SELECT c2.*,d.NombreDlcs,d.PrecioDlcs,d.ImagenDlcs FROM carrito AS c2 JOIN dlcs AS d ON d.IdDlcs = c2.juegos_id WHERE c2.usuario_id=:id AND c2.estado = '1'");
  $sentenciaSQL->bindParam(':id', $_SESSION['idCliente']);
  $sentenciaSQL->execute();
  $carrito2 = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

  $sentenciaSQL = $conexion->prepare("SELECT c3.*,co.NombreConsolas,co.PrecioConsolas,co.ImagenConsolas FROM carrito AS c3 JOIN consolas AS co ON co.IdConsolas = c3.juegos_id WHERE c3.usuario_id=:id AND c3.estado = '1'");
  $sentenciaSQL->bindParam(':id', $_SESSION['idCliente']);
  $sentenciaSQL->execute();
  $carrito3 = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);



  $tot = 0;



?>

  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Imagen</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Precio Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    
      <?php foreach ($carrito as $c) { ?>
        <tr>
          <td><?php echo $c['NombreJuegos']; ?></td>
          <td>
                <img class="img-thumbnail rounded" src="img/<?php echo $c['ImagenJuegos'];?>" width="70" alt="">
            </td>
          <td><?php echo $c['cantidad']; ?></td>
        
          <td><?php echo $c['PrecioJuegos']; ?></td>
          <td><?php echo $c['PrecioJuegos']*$c['cantidad']; ?></td>
          <td>
            <form action="eliminarCarrito.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
              <button class="btn btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php $tot = $tot+$c['PrecioJuegos']*$c['cantidad']; } ?>
     
        <?php foreach ($carrito1 as $c1) { ?>
        <tr>
          <td><?php echo $c1['NombreAccesorios']; ?></td>
          <td>
                <img class="img-thumbnail rounded" src="img/<?php echo $c1['ImagenAccesorios'];?>" width="70" alt="">
            </td>
          <td><?php echo $c1['cantidad']; ?></td>
        
          <td><?php echo $c1['PrecioAccesorios']; ?></td>
          <td><?php echo $c1['PrecioAccesorios']*$c1['cantidad']; ?></td>
          <td>
            <form action="eliminarCarrito.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $c1['id']; ?>">
              <button class="btn btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php $tot = $tot+$c1['PrecioAccesorios']*$c1['cantidad']; } ?>

        <?php foreach ($carrito2 as $c2) { ?>
        <tr>
          <td><?php echo $c2['NombreDlcs']; ?></td>
          <td>
                <img class="img-thumbnail rounded" src="img/<?php echo $c2['ImagenDlcs'];?>" width="70" alt="">
            </td>
          <td><?php echo $c2['cantidad']; ?></td>
          <td><?php echo $c2['PrecioDlcs']; ?></td>
          <td><?php echo $c2['PrecioDlcs']*$c2['cantidad']; ?></td>
          <td>
            <form action="eliminarCarrito.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $c2['id']; ?>">
              <button class="btn btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php $tot = $tot+$c2['PrecioDlcs']*$c2['cantidad']; } ?>
      
        
        <?php foreach ($carrito3 as $c3) { ?>
        <tr>
          <td><?php echo $c3['NombreConsolas']; ?></td>
          <td>
                <img class="img-thumbnail rounded" src="img/<?php echo $c3['ImagenConsolas'];?>" width="70" alt="">
            </td>
          <td><?php echo $c3['cantidad']; ?></td>
          <td><?php echo $c3['PrecioConsolas']; ?></td>
          <td><?php echo $c3['PrecioConsolas']*$c3['cantidad']; ?></td>
          <td>
            <form action="eliminarCarrito.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $c3['id']; ?>">
              <button class="btn btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php $tot = $tot+$c3['PrecioConsolas']*$c3['cantidad']; } ?>
      
      
    </tbody>
  </table>
<br>
  Total: <?php echo $tot; ?>

  <form action="pagar.php" method="post">
    <button type="submit" class="btn btn-success">Comprar</button>
  </form>

  