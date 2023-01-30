<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require_once 'controllers/AuthController.php';
// get request method
$method = $_SERVER['REQUEST_METHOD'];
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (isset($uriSegments[2]) && $uriSegments[2] == 'register') {
    $controller = new AuthController();
    $data = json_decode(file_get_contents('php://input'), true);
    return $controller->register($data);
} else {
    http_response_code(404);
    echo json_encode([
        'error' => true,
        'status' => 404,
        'message' => 'Tidak ada yang dapat ditampilkan'
    ]);
}


/* if ($method == 'GET') {
    echo json_encode($uriSegments);
}
if ($method == 'POST') {
    echo "THIS IS A POST REQUEST";
}
if ($method == 'PUT') {
    echo "THIS IS A PUT REQUEST";
}
if ($method == 'DELETE') {
    echo "THIS IS A DELETE REQUEST";
} */
