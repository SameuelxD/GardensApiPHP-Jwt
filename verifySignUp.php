<?php
ob_clean(); // Limpiar el búfer de salida

// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos GET, POST, PUT, DELETE, OPTIONS
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Permitir los encabezados Content-Type y Authorization
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Permitir cookies en las solicitudes cruzadas
header("Access-Control-Allow-Credentials: true");

// Establecer el tipo de contenido a JSON
header("Content-Type: application/json");

// Si la solicitud es OPTIONS, responde con éxito
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
// Función para verificar los roles
function checkRolsVerify($req)
{
    try {
        $database = new PDO('mysql:host=localhost;dbname=jardineria;charset=utf8mb4', 'root', '123456');
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($req['rol_id'])) {
            // Verificar si el rol existe en la base de datos
            $query = $database->prepare('SELECT * FROM Rol WHERE id = :rol_id');
            $query->bindParam(':rol_id', $req['rol_id']);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return ['error' => "El rol con ID '{$req['rol_id']}' no existe"];
            }
        }

        return true; // Devolvemos true si la verificación es exitosa
    } catch (PDOException $e) {
        return ['error' => 'Error interno del servidor'];
    }
}

// Función para verificar los usuarios
function checkUsersVerify($req)
{
    try {
        $database = new PDO('mysql:host=localhost;dbname=jardineria;charset=utf8mb4', 'root', '123456');
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si se proporcionan datos de usuario
        if (!isset($req['username']) || !isset($req['email'])) {
            return ['error' => 'Falta información de usuario'];
        }

        // Verificar si el nombre de usuario ya existe
        $queryUsername = $database->prepare('SELECT * FROM User WHERE username = :username');
        $queryUsername->bindParam(':username', $req['username']);
        $queryUsername->execute();
        $usernameRows = $queryUsername->fetchAll(PDO::FETCH_ASSOC);

        if (count($usernameRows) > 0) {
            return ['error' => 'El nombre de usuario ya existe'];
        }

        // Verificar si el correo electrónico ya existe
        $queryEmail = $database->prepare('SELECT * FROM User WHERE email = :email');
        $queryEmail->bindParam(':email', $req['email']);
        $queryEmail->execute();
        $emailRows = $queryEmail->fetchAll(PDO::FETCH_ASSOC);

        if (count($emailRows) > 0) {
            return ['error' => 'El correo electrónico ya existe'];
        }

        return true; // Devolvemos true si la verificación es exitosa
    } catch (PDOException $e) {
        return ['error' => 'Error interno del servidor'];
    }
}
