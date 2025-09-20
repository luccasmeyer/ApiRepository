<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

require_once __DIR__ . '/../repositories/UsersRepository.php';
header("Content-Type: application/json");

$repo = new UserRepository($pdo);
$response = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $uri = $_SERVER['REQUEST_URI'];
        $uriParts = explode('/', trim($uri, '/'));

        if (isset($uriParts[1]) && $uriParts[1] === 'count') {
            $total = $repo->countUsers();
            echo json_encode([
                "status" => "success",
                "count"  => $total
            ]);
            exit;
        }

        $id = $uriParts[1] ?? null;
        if ($id) {
            $user = $repo->listUser($id);

            echo json_encode([
                "status" => $user ? "success" : "error",
                "data"   => $user
            ]);
        } else {
            $users = $repo->listAllUsers();

            echo json_encode([
                "status" => $users ? "success" : "error",
                "data"   => $users
            ]);
        }
        break;

    case 'POST':
        $dataJson = file_get_contents("php://input");
        if(!$dataJson){
            echo json_encode([
                'status' => 'error',
                'message' => 'data de cadastro não enviado'
            ]);
            exit;
        }
        $data = json_decode($dataJson);
        $nameUser = $data->name ?? null;
        $email = $data->email ?? null;
        $password = $data->password ?? null;

        if(!$nameUser || !$email || !$password){
            echo json_encode([
                'status' => 'error',
                'message' => 'As informações necessarias não foram enviadas'
            ]);
            exit;
        }

        $user = $repo->createUser($nameUser, $email, $password);

        echo json_encode([
            http_response_code(201),
            'status' => 'Usuario criado',
            'message' => $user
        ]);
        break;

    case 'DELETE':
        $dataJson = file_get_contents("php://input");
        if(!$dataJson){
            echo json_encode([
                'status' => 'error',
                'message' => 'data de exclusão não enviada'
            ]);
            exit;
        }

        $data = json_decode($dataJson);
        $id = $data->id ?? null;
        $nameUser = $data->name ?? null;

        if(!$id || !$nameUser){
            echo json_encode([
                'status' => 'error',
                'message' => 'As informações necessárias não foram enviadas'
            ]);
            exit;
        }

        $user = $repo->deleteUser($id, $nameUser);

        echo json_encode([
            http_response_code(200),
            'status' => 'success',
            'message' => "Usuario excluído"
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

