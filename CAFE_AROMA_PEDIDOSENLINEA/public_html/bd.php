<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

// Validar
if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

$nombre = $data["nombre"];
$correo = $data["correo"];
$metodo = $data["metodo"];
$total = $data["total"];
$detalle = json_encode($data["detalle"], JSON_UNESCAPED_UNICODE);

// CONEXIÓN A MYSQL
$conexion = new mysqli("localhost", "projectintracool_BD", "W89dn9l@J[{gL38Q", "projectintracool_BD");

if ($conexion->connect_error) {
    echo json_encode(["status" => "error", "message" => $conexion->connect_error]);
    exit;
}

$stmt = $conexion->prepare("
    INSERT INTO pagos_cafe_aroma (nombre, correo, metodo, total, detalle)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssds", $nombre, $correo, $metodo, $total, $detalle);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Pago registrado correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
