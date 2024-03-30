<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once('verifySignUp.php');
require_once('vendor/autoload.php');

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once "connection.php";
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$findId = explode('/', $path);
$id = ($path !== '/') ? end($findId) : null;

$validPaths = ['/signup', '/signin'];
if (!in_array($path, $validPaths)) {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
    return;
}

switch ($path) {
    case '/signup':
        if ($method === 'POST') {
            $request = json_decode(file_get_contents("php://input"));
            if (!checkUsersVerify((array)$request) || !checkRolsVerify((array)$request)) {
                return;
            }
            signUp($request);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido para esta ruta']);
        }
        break;
    case '/signin':
        if ($method === 'POST') {
            $request = json_decode(file_get_contents("php://input"));
            signIn($request);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido para esta ruta']);
        }
        break;
    default:
        echo json_encode(['error' => 'Ruta Inexistente']);
        break;
}

function signUp($request)
{
    try {
        if (!isset($request->username) || !isset($request->email) || !isset($request->password) || !isset($request->rol_id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos de usuario incompletos']);
            return;
        }

        $db = new PDO('mysql:host=localhost;dbname=jardineria', 'root', '123456');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $db->prepare('SELECT * FROM User WHERE email = ?');
        $query->execute([$request->email]);
        $existingUserRows = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($existingUserRows) > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'El usuario ya existe']);
            return;
        }

        $query = $db->prepare('INSERT INTO User (username, email, password, rol_id) VALUES (?, ?, ?, ?)');
        $query->execute([$request->username, $request->email, $request->password, $request->rol_id]);

        $query = $db->prepare('SELECT u.id, u.username, u.email, u.rol_id, r.names as rol_name FROM User u JOIN Rol r ON u.rol_id = r.id WHERE u.id = ?');
        $query->execute([$db->lastInsertId()]);
        $userRows = $query->fetchAll(PDO::FETCH_ASSOC);
        $user = $userRows[0];

        $tokenPayload = [
            'id' => $user['id'],
            'user_name' => $user['username'],
            'addressEmail' => $user['email'],
            'rol_id' => $user['rol_id'],
            'rol_name' => $user['rol_name']
        ];
        $token = JWT::encode($tokenPayload, SECRET, 'HS256');

        echo json_encode(['token' => $token, 'success' => 'Registro exitoso']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error interno del servidor al registrar el usuario']);
    }
}

function signIn($request)
{
    try {
        if (!isset($request->email) || !isset($request->password)) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos de inicio de sesión incompletos']);
            return;
        }

        $db = new PDO('mysql:host=localhost;dbname=jardineria', 'root', '123456');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $db->prepare('SELECT u.id, u.username, u.email, u.rol_id, r.names as rol_name FROM User u JOIN Rol r ON u.rol_id = r.id WHERE u.email = ? AND u.password = ?');
        $query->execute([$request->email, $request->password]);
        $userRows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($userRows) === 0) {
            http_response_code(401);
            echo json_encode(['error' => 'Correo electrónico o contraseña inválidos']);
            return;
        }

        $user = $userRows[0];

        $tokenPayload = [
            'id' => $user['id'],
            'user_name' => $user['username'],
            'addressEmail' => $user['email'],
            'rol_id' => $user['rol_id'],
            'rol_name' => $user['rol_name']
        ];
        $token = JWT::encode($tokenPayload, SECRET, 'HS256');

        // Establecer el token como una cookie
        setcookie('x-access-token', $token, time() + (86400 * 30), '/', '', false, true);


        echo json_encode(['token' => $token, 'success' => 'Inicio de sesión exitoso']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error interno del servidor al iniciar sesión']);
    }
}
