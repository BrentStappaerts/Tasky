<?php

require_once('Db.class.php');
class Lijst {
    private $m_sName;
    
    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty){
            case "Name":
                $this->m_sName = $p_vValue;
                break;
        }
    }
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Name":
                return $this->m_sName;
                break;
        }
    }

    public function Add() {
        if(!empty($this->m_sName)){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO lists (name, userID) values (:name, :userID)");
            $statement->bindValue(":name", $this->m_sName);
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }

    public function getAll(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT name FROM lists WHERE userID = :userID");
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
            $allLists = $statement->fetchAll(PDO::FETCH_COLUMN);
            return $allLists;
    }

    public function deleteList(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("DELETE * FROM lists");
            $statement->execute();
    }
}
?>

