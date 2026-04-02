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

//Se obtienen el nie que introdujo el usuario
$nie = $datos["nie"];

//Se realiza la consulta a la BD - Estudiantes
$consulta = "SELECT * FROM Estudiante WHERE nie = '$nie'";
$resultado = $conexion -> query($consulta);

//Verificando si se insertaron 
if ($resultado && $resultado -> num_rows > 0){
    //Enviamos mensaje de que si se recibio
    echo json_encode(["success" => true, "tipo" => "estudiante"]);
    exit;
} 

//Se realiza la consulta a la BD - Maestros (Director)
$consulta2 = "SELECT * FROM Profesor WHERE contra = '$nie'";
$resultado2 = $conexion -> query($consulta2);

//Verificando si se insertaron 
if ($nie == "9988"){
    //Enviamos mensaje de que si se recibio
    echo json_encode(["success" => true, "tipo" => "director"]);
    exit;
} 

//Se realiza la consulta a la BD - Maestros
$consulta3 = "SELECT * FROM Profesor WHERE contra = '$nie'";
$resultado3 = $conexion -> query($consulta3);

//Verificando si se insertaron 
if ($resultado3 && $resultado3 -> num_rows > 0){
    //Enviamos mensaje de que si se recibio
    echo json_encode(["success" => true, "tipo" => "maestro"]);
    exit;
}

echo json_encode(["success" => false]);

$conexion->close();
?>