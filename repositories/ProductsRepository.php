<?php

class ProductsRepository{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function listAllProducts(){
        $stmt = $this->pdo->prepare("SELECT * FROM PRODUCTS");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listProduct($id){
        $stmt = $this->pdo->prepare("SELECT * FROM PRODUCTS WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


?>