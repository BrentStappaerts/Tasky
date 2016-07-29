<?php

require_once('Db.class.php');
include_once("Lijst.class.php");

class Deadline {
    private $m_sTitel;
    private $m_sVak;
    private $m_iDatum;
    private $m_sDeadlineID;
    private $m_sListID;

    
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
            case "DeadlineID":
                $this->m_sDeadlineID = $p_vValue;
                break;
            case "ListID":
                $this->m_sListID = $p_vValue;
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
            case "DedlineID":
                return $this->m_sDaedlineID;
                break;
            case "ListID":
                return $this->m_sListID;
                break;
        }
    }

    public function Add() {
        if(!empty($this->m_sTitel) && !empty($this->m_sVak) && !empty($this->m_iDatum)){
            $listID = $_GET['list'];
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO deadlines (titel, vak, datum, userID, listID) values (:titel, :vak, :datum, :userID, :listID)");
            $statement->bindValue(":titel", $this->m_sTitel);
            $statement->bindValue(":vak", $this->m_sVak);
            $statement->bindParam(":datum", $this->m_iDatum);
            $statement->bindParam(":listID", $listID);
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }
    public function getAll(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT * FROM deadlines WHERE userID = :userID");
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
            $allTasks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $allTasks;
    }

    public function getTask(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT * FROM deadlines");
            $statement->bindValue(":deadlineID", $this->m_sDeadlineID);
            $statement->execute();
            $oneTask = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $oneTask;
    }
}
?>



