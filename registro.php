<?php
// base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "valida_form";

// conexión bbdd
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// datos del formulario
$nombre = $_POST["nombre"];
$apellido1 = $_POST["apellido1"];
$apellido2 = $_POST["apellido2"];
$email = $_POST["email"];
$login = $_POST["login"];
$password = $_POST["password"];

// validación
if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($password)) {
    die("Por favor, completa todos los campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("El email ingresado no es válido.");
}

if (strlen($password) < 4 || strlen($password) > 8) {
    die("La contraseña debe tener entre 4 y 8 caracteres.");
}

// Verificar registro
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    die("El email ingresado ya está registrado.");
}

// datos a la base de datos
$sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, login, password) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registro completado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>