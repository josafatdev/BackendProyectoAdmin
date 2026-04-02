<?php
//Datos de Conexión
$host = "localhost"; //Siempre localhost
$base = "Escuela";  //Cambia segun nombre de DB
$usuario = "Mesa_1"; //Cambia segun usuario
$contra = "31122007"; //Cambia segun usuario

//Conexion
$conexion = mysqli_connect($host, $usuario, $contra, $base);

//Mensaje de error que se muestra si la conexión falla
if (!$conexion){
    die("Error al conectar..." . mysqli_connect_error());
}
?>