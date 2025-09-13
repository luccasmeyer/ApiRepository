<?php
require_once __DIR__ . '/../repositories/UsersRepository.php';


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
        $data = json_decode(file_get_contents("php://input"), true);
        $user = $repo->createUser($data['name'], $data['email'], $data['password']);
        
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

?>