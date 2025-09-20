<?php

class UserRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function listAllUsers(){
        $stmt = $this->pdo->prepare("SELECT * FROM USERS");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listUser($id){
        $stmt = $this->pdo->prepare("SELECT * FROM USERS WHERE id = :idUser");
        $stmt->bindParam('idUser', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createUser($name, $email, $password) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO USERS (nameuser, email, passworduser) VALUES (:name, :email, :password)"
        );

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function deleteUser($id, $name){
        $stmt = $this->pdo->prepare(
            "DELETE FROM USERS WHERE id = :id AND nameuser = :nameuser"
        );

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nameuser', $name, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }
}

