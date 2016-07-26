<?php

require_once('Db.class.php');
class Deadline {
    private $m_sTitel;
    private $m_sVak;
    private $m_iDatum;
    private $m_iListID;
    
    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty){
            case "Titel":
                $this->m_sTitel = $p_vValue;
                break;
            case "Vak":
                $this->m_sVak = $p_vValue;
                break;
            case "Datum";
                $this->m_iDatum = $p_vValue;
                break;
            case "ListID";
                $this->m_iListID = $p_vValue;
                break;
        }
    }
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Titel":
                return $this->m_sTitel;
                break;
            case "Vak":
                return $this->m_sVak;
                break;
            case "Datum":
                return $this->m_iDatum;
                break;
            case "ListID":
                return $this->m_iListID;
                break;
        }
    }

    public function Add() {
        if(!empty($this->m_sTitel) && !empty($this->m_sVak) && !empty($this->m_iDatum)){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO deadlines (titel, vak, datum, userID) values (:titel, :vak, :datum, :userID)");
            $statement->bindValue(":titel", $this->m_sTitel);
            $statement->bindValue(":vak", $this->m_sVak);
            $statement->bindParam(":datum", $this->m_iDatum);
            $statement->bindParam(":listID", $this->m_iListID);
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }
    public function getAll(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT titel FROM deadlines WHERE userID = :userID");
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
            $allTasks = $statement->fetchAll(PDO::FETCH_COLUMN);
            return $allTasks;
    }
}
?>

