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

//Se reciben los datos enviados y se decodifican de JSON a array asociativo de PHP
$datos = json_decode(file_get_contents('php://input'), true);

$nombre = $datos['nombreMaestro']; //El nombre dentro de los corchetes
$edad = $datos['edadMaestro'];
$espc = $datos['especialidad'];

//Se insertan los datos
$mariadb = "INSERT INTO Profesor (nombre, edad, especialidad) VALUES ('$nombre', '$edad', '$espc')";

//Verificando si se insertaron
if ($conexion -> query($mariadb)){
    //Enviamos mensaje de que si se recibio
    echo json_encode(["mensaje" => "Datos recibidos correctamente"]);
} else {
    //Enviamos mensaje de que no se recibio
    echo json_encode(["error" => "No se insertaron los datos correctamente"]);
}

$conexion->close();
?>