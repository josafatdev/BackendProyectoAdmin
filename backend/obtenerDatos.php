<?php
//Configuració Temporal para ver si si sirve si ono
//Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

//Llamamos al archivo que posee los datos de conexión
require_once("conexion.php");

//Hacemos la consulta SQL y la almacenamos en una variable
$mariadbdos = "SELECT * FROM Profesor"; //Consulta todos los registros de la tabla
$consulta = $conexion -> query($mariadbdos);

//Creamos un array donde almacenar los datos obtenidos
$datasos = [];

//Declaramos un bucle donde almacenaremos cada fila de datos en el array
while ($fila = $consulta -> fetch_assoc()){
    $datasos[] = $fila;
}

//Convierte los datos del array en un archivo JOTASON
echo json_encode($datasos);

$conexion->close();
?>