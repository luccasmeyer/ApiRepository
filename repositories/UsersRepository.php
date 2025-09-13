<?php

class UsuarioRepository {
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
        $stmt = $this->pdo->prepare("SELECT * FROM USERS WHERE :idUser");
        $stmt->bindParam('idUser', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function creatUser($name, $email, $password){
        $stmt = $this->pdo->prepare("INSERT INTO USERS (nameuser, email, passworduser) VALUES (:nameuser, :emailuser, :passworduser)");

        $stmt->bindParam(':nameuser', $name);
        $stmt->bindParam(':emailuser', $email);
        $stmt->bindParam(':passworduser', $password);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id, $name){
        $stmt = $this->pdo->prepare("DELETE FROM USER WHERE (:id, :nameuser)");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nameuser', $name);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>