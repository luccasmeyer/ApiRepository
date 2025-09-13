<?php


header("Content-Type: application/json; charset=UTF-8");


//linka a conexao do bando
require_once "config.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// /api/usuarios -> $uri[2] = usuarios
$endpoint = $uri[1] ?? null;

//roteamento API
switch ($endpoint) {
    case 'users':
        require "controllers/Users.php";
        break;
    case "products":
        require "controllers/Product.php";
        break;
    case "categories":
        require "controllers/Category.php";
        break;
    case "orders":
        require "controllers/Order.php";
        break;
    
    default:
        http_response_code(404);
        echo json_encode(["erro" => "Endpoint não encontrado"]);
}

?>