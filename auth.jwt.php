<?php

require_once 'config.php'; // Asegúrate de incluir el archivo de configuración si es necesario
require_once 'vendor/autoload.php';

use Firebase\JWT\JWT;



// Configuración CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

function verifyToken($req, $sendResponse, $next)
{
    try {
        $token = $_COOKIE['x-access-token'];
        if (!$token) {
            $sendResponse(403, ['message' => 'No token provided']);
        }

        $decoded = JWT::decode($token, SECRET, array('HS256'));

        if (!$decoded || !isset($decoded->id) || !isset($decoded->rol_name)) {
            $sendResponse(401, ['message' => 'Unauthorized']);
        }

        // Convertir $req en un objeto si es un array
        if (is_array($req)) {
            $req = (object) $req;
        }

        // Define $req si aún no está definida
        $req = isset($req) ? $req : new stdClass();

        $req->userId = $decoded->id;
        $req->userRole = $decoded->rol_name;

        // Imprimir el objeto con la información del usuario
        $next($req);
    } catch (Exception $error) {
        error_log("Error: " . $error->getMessage());
        $sendResponse(401, ['message' => 'Unauthorized']);
    }
}

function hasRole($requiredRole)
{
    return function ($req, $sendResponse, $next) use ($requiredRole) {
        try {

            if (!isset($req->userRole)) {
                $sendResponse(401, ['message' => 'Unauthorized: User role not defined']);
            }

            $roleHierarchy = [
                'user' => 0,
                'moderator' => 1,
                'admin' => 2
            ];

            $requiredRoleLevel = $roleHierarchy[$requiredRole];
            $userRoleLevel = $roleHierarchy[$req->userRole];

            if ($userRoleLevel >= $requiredRoleLevel || $req->userRole === 'admin') {
                $next($req);
            } else {
                $sendResponse(403, ['message' => 'Require ' . $requiredRole . ' Role']);
            }
        } catch (Exception $error) {
            error_log("Error: " . $error->getMessage());
            $sendResponse(500, ['message' => 'Internal Server Error']);
        }
    };
}

function isUser($req, $sendResponse, $next)
{
    hasRole('user')($req, $sendResponse, $next);
}

function isModerator($req, $sendResponse, $next)
{
    hasRole('moderator')($req, $sendResponse, $next);
}

function isAdmin($req, $sendResponse, $next)
{
    hasRole('admin')($req, $sendResponse, $next);
}
