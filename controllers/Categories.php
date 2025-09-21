<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../repositories/UsersRepository.php';
header("Content-Type: application/json");

$repo = new CategoriesRepository($pdo);

switch ($_SERVER['REQUEST_METHOD']){
    case 'GET':



        break;
    case 'POST':
        $dataJson = file_get_contents("php://input");
        if(!$dataJson){
            echo json_encode([
                'status' => 'error',
                'message' => 'data da requisição não enviado'
            ]);
        }

        $data = json_decode($dataJson);

        $nameCategory = $data->nameCategory ?? null;
        $description = $data->description ?? null;



        if(!$nameCategory || !$description){
            echo json_encode([
                'status' => 'error',
                'message' => 'Parêmetros não passados'
            ]);
        }

        $category = $repo->createCategory($nameCategory, $description);

        echo json_encode([
            'status' => 'success',
            'message' => 'Categoria criada',
            'data' => $category
        ]);
        break;
}
