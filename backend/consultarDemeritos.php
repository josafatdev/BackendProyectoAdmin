<?php
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

//Consulta para obtener datos más el número de deméritos
$consulta = "SELECT e.*, COUNT(d.id_demerito) as total_demeritos
            FROM Estudiante e
            LEFT JOIN Demeritos d ON e.id = d.id_estudiante
            WHERE e.nie = '$nie'
            GROUP BY e.id";

$resultado = $conexion -> query($consulta);

if ($resultado && $resultado -> num_rows > 0){
    $estudiant = $resultado -> fetch_assoc();

    echo json_encode([
        "success" => true,
        "tipo" => "estudiante",
        "id" => $estudiant["id"],
        "nombre" => $estudiant["nombre"],
        "apellido" => $estudiant["apellido"],
        "nie" => $estudiant["nie"],
        "grado" => $estudiant["grado"],
        "seccion" => $estudiant["seccion"],
        "turno" => $estudiant["turno"],
        "tiene_demeritos" => ($estudiant["total_demeritos"] > 0),
        "total_demeritos" => (int)$estudiant["total_demeritos"]
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Estudiante no encontrado..."]);
}

$conexion -> close();
?>