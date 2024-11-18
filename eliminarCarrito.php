<?php

include("administrador/config/bd.php");

$id = (isset($_POST['id'])) ? $_POST['id'] : "";

$sentenciaSQL = $conexion->prepare("DELETE FROM carrito WHERE id=:id");
$sentenciaSQL->bindParam(':id', $id);
$sentenciaSQL->execute();

header("Location:carrito.php");

?>