<?php

$nombre_usuario = "root@localhost";
$contrasena = "";

// Conexión a base de datos
$servername = "127.0.0.1"; 
$username = "usuario_db";
$password = "contrasena_db";
$database = "tarea-17";

$conn = new mysqli($servername, $username, $password, $database);

// Verifico la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)");
$hash_contrasena = password_hash($contrasena, PASSWORD);


$stmt->bind_param("ss", $nombre_usuario, $hash_contrasena);

// hafo una consulta

if ($stmt->execute()) {
    echo "Registro exitoso para $nombre_usuario";
} else {
    echo "Error al registrar el usuario: " . $stmt->error;
}
// y cierro la conexxion con el servidor
$stmt->close();
$conn->close();


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $saludo = "¡Hola $nombre!";
    echo $saludo;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cantidad']) && isset($_GET['moneda_origen']) && isset($_GET['moneda_destino'])) {
    $cantidad = $_GET['cantidad'];
    $moneda_origen = $_GET['moneda_origen'];
    $moneda_destino = $_GET['moneda_destino'];

    // se supone que realiza la conversión 

    $tasa_conversion = 0.8417; // 1 USD = 0.8417 EUR
    if ($moneda_origen === 'USD' && $moneda_destino === 'EUR') {
        $resultado = $cantidad * $tasa_conversion;
        echo "$cantidad USD = $resultado EUR";
    } elseif ($moneda_origen === 'EUR' && $moneda_destino === 'USD') {
        $resultado = $cantidad / $tasa_conversion;
        echo "$cantidad EUR = $resultado USD";
    } else {
        echo "Las monedas de origen y destino no son compatibles.";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_usuario']) && isset($_POST['contrasena'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Se realiza la conexión a la base de datos y consulta de inserción
    // Si se agrego devuelve una respuesta de confirmación
    echo "Registro exitoso para $nombre_usuario";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_usuario']) && isset($_POST['contrasena'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Si todo esta bien deveria dar una respuesta de inicio de sesión
    echo "Inicio de sesión exitoso para $nombre_usuario";
    // Sino, muestra un mensaje de error
    echo "Credenciales incorrectas";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $productos = [
        ['nombre' => 'Producto 1', 'descripcion' => 'Descripción del Producto 1', 'precio' => 19.99],
        ['nombre' => 'Producto 2', 'descripcion' => 'Descripción del Producto 2', 'precio' => 29.99],
      
    ];

    // Devuelve la lista de productos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($productos);
}


?>