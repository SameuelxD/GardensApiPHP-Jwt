<?php
$host = "localhost";
$usuario = "root";
$password = "123456";
$db = "jardineria";

$conexion = new mysqli($host, $usuario, $password, $db);

if ($conexion->connect_error) {
    die("Conexion no establecida" . $conexion->connect_error);
}
