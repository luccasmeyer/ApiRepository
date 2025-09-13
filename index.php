<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

//linka a conexao do bando
require_once "config.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// /api/usuarios -> $uri[2] = usuarios
$endpoint = $uri[2] ?? null;

//roteamento API
switch ($endpoint) {
    case 'users':
        require "endpoints/users.php";
        break;
    case "products":
        require "endpoints/products.php";
        break;
    case "categories":
        require "endpoints/categories.php";
        break;
    case "orders":
        require "endpoints/orders.php";
        break;
    
    default:
        http_response_code(404);
        echo json_encode(["erro" => "Endpoint não encontrado"]);
}

?>