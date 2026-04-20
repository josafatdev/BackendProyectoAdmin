<?php
//Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept, Origin");
header("Access-Control-Max-Age: 86400");
header("Content-Type: application/json");

// Intentar incluir conexion.php
require_once("conexion.php");

// Verificar que $conexion existe y es válido
if (!isset($conexion) || !$conexion) {
    error_log("[DEMERITO] ERROR: \$conexion no está definida o es null");
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "conexion_null"]);
    exit;
}
error_log("[DEMERITO] \$conexion válida");

// Leer input
$rawInput = file_get_contents('php://input');
$datos = json_decode($rawInput, true);
error_log("[DEMERITO] Input recibido: " . substr($rawInput, 0, 200));

// Validar datos
if (!$datos || !isset($datos["id_estudiante"])) {
    error_log("[DEMERITO] ERROR: Datos incompletos");
    echo json_encode(["success" => false, "error" => "datos_incompletos"]);
    exit;
}


try {
    $id_estudiante = (int)$datos["id_estudiante"];
    $descripcion = $conexion->real_escape_string($datos["descripcion"] ?? "");
    $fecha = $conexion->real_escape_string($datos["fecha"] ?? "");
    $responsable = $conexion->real_escape_string($datos["responsable"] ?? "");
    error_log("[DEMERITO] Datos sanitizados");
} catch (Exception $e) {
    error_log("[DEMERITO] ERROR en sanitización: " . $e->getMessage());
    echo json_encode(["success" => false, "error" => "sanitize_error"]);
    exit;
}

// Acciones a JSON
$acciones = '[]';
if (!empty($datos["acciones"]) && is_array($datos["acciones"])) {
    $acciones = $conexion->real_escape_string(json_encode($datos["acciones"], JSON_UNESCAPED_UNICODE));
}

$consulta = "INSERT INTO Demeritos (id_estudiante, id_profesor, descripcion, fecha, responsable, acciones_correctivas) 
             VALUES ($id_estudiante, NULL, '$descripcion', '$fecha', '$responsable', '$acciones')";
error_log("[DEMERITO] Query: $consulta");

$resultado = $conexion->query($consulta);

if ($resultado === TRUE) {
    error_log("[DEMERITO] INSERT exitoso, ID: " . $conexion->insert_id);
    echo json_encode(["success" => true, "id_demerito" => $conexion->insert_id]);
} else {
    error_log("[DEMERITO] ERROR en query: " . $conexion->error);
    echo json_encode(["success" => false, "error" => "query_error"]);
}

$conexion->close();
?>