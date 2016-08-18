<?php

require_once('Db.class.php');

class User {

    private $m_sEmail;
    private $m_sName;
    private $m_sPassword;
    private $m_sImage;
    
    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty){
            case "Email":
                $this->m_sEmail = $p_vValue;
                break;
            case "Name":
                $this->m_sName = $p_vValue;
                break;
            case "Password":
                $this->m_sPassword = $p_vValue;
                break;
            case "Image":
                $this->m_sImage = $p_vValue;
                break;
        }
    }
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Email":
                return $this->m_sEmail;
                break;
            case "Name":
                return $this->m_sName;
                break;
            case "Password":
                return $this->m_sPassword;
                break;
            case "Image":
                return $this->m_sImage;
                break;
        }
    }
    public function canLogin() {
        if(!empty($this->m_sEmail) && !empty($this->m_sPassword)){

            $PDO =  Db::getInstance();
            $stmt = $PDO->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindValue(":email", $this->m_sEmail, PDO::PARAM_STR );
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $password = $this->m_sPassword;
                $hash = $result['password'];

                if(password_verify($password, $hash)) {
                    $this->createSession($result['user_id']);
                    return true;
                } else{
                    return false;
                }
            } else {
                return false;
            }
        }
    }
    public function Register() {
        $PDO = Db::getInstance();
        $password = $this->m_sPassword;

         if(!empty($this->m_sEmail) && !empty($this->m_sPassword) && !empty($this->m_sName)){
            if(strlen($password) > 5 && strlen($password) < 21){
                if(filter_var("some@address.com", FILTER_VALIDATE_EMAIL)) {
                    $statement = $PDO->prepare("INSERT INTO users (email, password, name) values (:email, :password, :name)");
                    $options = [ 'cost' => 12];
                    $password = password_hash($this->m_sPassword, PASSWORD_DEFAULT, $options);
                    $statement->bindValue(":email", $this->m_sEmail);
                    $statement->bindValue(":password", $password);
                    $statement->bindValue(":name", $this->m_sName);
                    $statement->execute();
                   }else {
                         throw new Exception("Geen geldige email.");
                        }
             }else {
            throw new Exception("Wachtwoord moet tussen de 5 en 21 tekens bevatten.");
             }

        }else {
            throw new Exception("Gelieve alle velden in te vullen");
        }
    }

    private function createSession($id) {
        session_start();
        $_SESSION["user_id"] = $id;
    }

    public function Upload() {
        $PDO = Db::getInstance();                 
        $stmt = $PDO->prepare("UPDATE users SET user_image = :user_image WHERE user_id = :user_id");
        $stmt->bindParam(":user_image", $this->m_sImage);
        $stmt->bindParam(":user_id", $_SESSION['user_id']);
        $stmt->execute(); 
    }
}