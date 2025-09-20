<?php

    class ProductsRepository{
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function listAllProducts(){
            $stmt = $this->pdo->prepare("SELECT * FROM PRODUCTS");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function listProduct($id){
            $stmt = $this->pdo->prepare("SELECT * FROM PRODUCTS WHERE id = :idProduct");
            $stmt->bindParam('idProduct', $id);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

//        public function insertProduct(){
//            $stmt = $this->pdo->prepare("INSERT INTO PRODUCTS (nameproduct, descr)");
//        }

        public function countUser(){
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM PRODUCT");

            $stmt->execute();
            $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $return['total'] ?? 0;
        }
    }