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

//Obtiene los id provenientes desde el JSON
$id = $datos["ids"]; // ids : Lugar del JSON donde se almacenan los ID de cada registro

//Convierte el array con los ID generados en un string para usar en la consulta.
$cadena = implode(",", $id);

//Consulta SQL para eliminar los ID seleccionados por el usuario.
$eliminadasos = "DELETE FROM Profesor WHERE id IN ($cadena)";

//Verificando si se insertaron
if ($conexion -> query($eliminadasos)){
    //Enviamos mensaje de que si se recibio
    echo json_encode(["mensaje" => "Profesores eliminados correctamente"]);
} else {
    //Enviamos mensaje de que no se recibio
    echo json_encode(["error" => "No se eliminaron los profesores correctamente"]);
}

$conexion->close();
?>