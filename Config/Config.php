<?php
const BASE_URL = "http://localhost/neumati/";
const HOST = "localhost";
const USER = "root";
const PASS = ""; // Deja la cadena de contraseña vacía
const DB = "neumático rd";
const CHARSET = "utf8";
const TITLE = "Neumático rd";
const MONEDA = "USD";
const CLIENT_ID = "";

// Función para conectar a la base de datos
function conectarBD() {
    $conn = new mysqli(HOST, USER, PASS, DB);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Establecer el conjunto de caracteres
    $conn->set_charset(CHARSET);

    return $conn;
}
?>
