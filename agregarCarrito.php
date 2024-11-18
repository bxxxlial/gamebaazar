<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location:inicio.php");
}

include("administrador/config/bd.php");

$usu = $_SESSION['idCliente'];
$jue = (isset($_POST['juegos'])) ? $_POST['juegos'] : "";
$cant = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : "";
$est = 1;

$sentenciaSQL = $conexion->prepare("INSERT INTO carrito (usuario_id,juegos_id,cantidad,estado) VALUES (:usuario_id,:juegos_id,:cantidad,:estado);");
$sentenciaSQL->bindParam(':usuario_id', $usu);
$sentenciaSQL->bindParam(':juegos_id', $jue);
$sentenciaSQL->bindParam(':cantidad', $cant);
$sentenciaSQL->bindParam(':estado', $est);
$sentenciaSQL->execute();
header("Location:carrito.php");

?>

