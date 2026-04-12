<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

//Datos de Conexión
$host = "localhost"; //Siempre localhost
$base = "Escuela";  //Cambia segun nombre de DB
$usuario = "Mesa_1"; //Cambia segun usuario
$contra = "31122007"; //Cambia segun usuario

//Conexion
$conexion = mysqli_connect($host, $usuario, $contra, $base);

//Codificacion utf-8
mysqli_set_charset($conexion, "utf8mb4");

//Mensaje de error que se muestra si la conexión falla
if (!$conexion){
    die("Error al conectar..." . mysqli_connect_error());
}
?>