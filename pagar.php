<?php
session_start();
include("administrador/config/bd.php");

$id = $_SESSION['idCliente'];

$sentenciaSQL = $conexion->prepare("UPDATE carrito SET estado=0 WHERE usuario_id=:id");
$sentenciaSQL->bindParam(':id', $id);
$sentenciaSQL->execute();

header("Location:carrito.php");

?>