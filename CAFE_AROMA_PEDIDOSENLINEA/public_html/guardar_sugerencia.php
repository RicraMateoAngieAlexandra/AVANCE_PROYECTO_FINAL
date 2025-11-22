<?php
// =============================
// CONEXIÓN A LA BD
// =============================
$conexion = new mysqli("localhost", "projectintracool_BD", "W89dn9l@J[{gL38Q", "projectintracool_BD");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// =============================
// CAPTURAR DATOS DEL FORM
// =============================
$nombre  = $_POST['nombre'];
$email   = $_POST['email'];
$mensaje = $_POST['mensaje'];

// =============================
// INSERTAR EN LA BD
// =============================
$sql = "INSERT INTO sugerencias (nombre, email, mensaje, fecha_registro)
        VALUES (?, ?, ?, NOW())";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre, $email, $mensaje);

if ($stmt->execute()) {
    echo "<script>alert('¡Gracias por tu sugerencia!'); window.location.href='https://project.intracool.site/';</script>";
} else {
    echo "Error al guardar: " . $conexion->error;
}

$stmt->close();
$conexion->close();
?>
