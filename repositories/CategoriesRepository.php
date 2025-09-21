<?php

    class CategoriesRepository{
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function listAllCategories(){
            $stmt = $this->pdo->prepare("SELECT * FROM CATEGORIES");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function listCategory($idCategory){
            $stmt = $this->pdo->prepare("SELECT * FROM CATEGORIES WHERE id = :id");
            $stmt->bindParam(':id', $idCategory);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createCategory($nameCategory, $description){
            $stmt = $this->pdo->prepare("INSERT INFO CATEGORIES (namecategory, description) VALUES (:nameCategory, :description)");

            $stmt->bindParam(':nameCategory', $nameCategory);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            return $this->pdo->lastInsertId();
        }

        public function countCategories(){
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total CATEGORIES");
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        }
}
