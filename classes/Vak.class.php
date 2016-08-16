<?php

require_once('Db.class.php');

class Vak {

    private $m_iVakID;
    private $m_sVakNaam;
    
    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty){
            case "VakID":
                $this->m_iVakID = $p_vValue;
                break;  
            case "VakNaam":
                $this->m_sVakNaam = $p_vValue;
                break;       
        }
    }

    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "VakID":
                return $this->m_iVakID;
                break;
            case "VakNaam":
                return $this->m_sVakNaam;
                break;
        }
    }

    public function Add() {
        if(!empty($this->m_sVakNaam)){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO vakken (vak_name) values (:vak_name)");
            $statement->bindParam(":vak_name", $this->m_sVakNaam);
            $statement->execute();
        }
        else {
            throw new Exception("Vak empty");
        }
    }
    public function getAll(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT * FROM vakken");
            $statement->execute();
            $vakken = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $vakken;
    }

    public function deleteVak(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("DELETE FROM vakken WHERE vak_id = :vak_id");
            $statement->bindValue(":vak_id", $this->m_iVakID);
            $statement->execute();
    }

    public function updateVak(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("UPDATE vakken SET vak_name = :vak_name WHERE vak_id = :vak_id");
            $statement->bindParam(":vak_name", $this->m_sVakNaam);
            $statement->bindValue(":vak_id", $this->m_iVakID);
            $statement->execute();
    }
}
?>



