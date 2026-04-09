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
$id_estudiante = (int)$datos["id_estudiante"];

//Obtener demértitos ordenados desde el más reciente al más antiguo
$consulta = "SELECT id_demerito, descripcion, fecha, responsable, acciones_correctivas, fecha_registro
            FROM Demeritos
            WHERE id_estudiante = $id_estudiante
            ORDER BY fecha DESC, fecha_registro DESC";

$resultado = $conexion -> query($consulta);

$demeritos = [];
if ($resultado && $resultado -> num_rows > 0){
    while($row = $resultado -> fetch_assoc()){

        //Pasar las acciones correctivas de JSON a array
        $acciones = json_decode($row["acciones_correctivas"] ?? '[]', true);

        $demeritos[] = [
            "id" => $row["id_demerito"],
            "descripcion" => $row["descripcion"],
            "fecha" => $row["fecha"],
            "responsable" => $row["responsable"],
            "acciones" => $acciones,
            "fecha_registro" => $row["fecha_registro"]
        ];
    }
}

echo json_encode([
    "success" => true,
    "total" => count($demeritos),
    "demeritos" => $demeritos
]);

$conexion -> close();

?>