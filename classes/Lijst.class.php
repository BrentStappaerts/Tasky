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
            $statement = $PDO->prepare("INSERT INTO lists (name) values (:name)");
            $statement->bindValue(":name", $this->m_sName);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }

    public function getAll(){
            $PDO = Db::getInstance();
            $allLists = $PDO->query("SELECT name FROM lists;")->fetchAll(PDO::FETCH_COLUMN);
            return $allLists;
    }
}
?>