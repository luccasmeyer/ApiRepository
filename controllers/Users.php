<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

require_once __DIR__ . '/../repositories/UsersRepository.php';
header("Content-Type: application/json");

$repo = new UserRepository($pdo);


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET['id'])){
            $user = $repo->listUser($id);

            echo json_encode([
                "status" => $user ? "ok" : "error",
                "data" => $user
            ]);
        } else {
            $users = $repo->listAllUsers();

            echo json_encode([
                "status" => $users ? "ok" : "error",
                "data" => $users
            ]);
        }
        break;

    case 'POST':
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!$name || !$email || !$password) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Campos obrigatórios faltando",
                "recebido" => $data
            ]);
            exit;
        } else {
            
            $user = $repo->createUser($name, $email, $password );
        }
        
        echo json_encode([
            "status" => "ok",
            "user" => $user
        ]);
        break;
    
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $user = $repo->deleteUser($data['id'], $data['name']);

        echo json_encode([
            "status" => "ok"
        ]);
        
        break;
       
    default:
        http_response_code(405);
        echo json_encode([
            "status" => "error",
            "message" => "metodo não permitido"
        ]);
        break;
}

