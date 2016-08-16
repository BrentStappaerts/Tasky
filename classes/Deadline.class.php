<?php

require_once('Db.class.php');
include_once("Lijst.class.php");

class Deadline {
    private $m_sTitel;
    private $m_sVak;
    private $m_iDatum;
    private $m_sDeadlineID;
    private $m_sListID;
    private $m_sWerkdruk;

    
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
            case "Werkdruk":
                $this->m_sWerkdruk = $p_vValue;
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
                return $this->m_sDeadlineID;
                break;
            case "ListID":
                return $this->m_sListID;
                break;
            case "Werkdruk":
                return $this->m_sWerkdruk;
                break;
        }
    }

    public function Add() {
        if(!empty($this->m_sTitel) && !empty($this->m_sVak) && !empty($this->m_iDatum)){
            $listID = $_GET['list'];
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO deadlines (titel, vak, datum, userID, listID, werkdruk) values (:titel, :vak, :datum, :userID, :listID, :werkdruk)");
            $statement->bindValue(":titel", $this->m_sTitel);
            $statement->bindValue(":vak", $this->m_sVak);
            $statement->bindParam(":datum", $this->m_iDatum);
            $statement->bindParam(":listID", $listID);
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->bindValue(":werkdruk", $this->m_sWerkdruk);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }
    public function getAll(){
            $listID = $_GET['list'];
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT * FROM deadlines WHERE userID = :userID AND listID = :listID AND datum > CURRENT_DATE() ORDER BY datum ASC");
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->bindParam(":listID", $listID);
            $statement->execute();
            $allTasks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $allTasks;
    }

    public function getTask(){
            $deadlineID = $_GET['Task'];
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("SELECT * FROM deadlines WHERE deadline_id = :deadlineID");
            $statement->bindValue(":deadlineID", $deadlineID);
            $statement->execute();
            $oneTask = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $oneTask;
    }

    public function done(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("UPDATE deadlines SET done = 1 WHERE deadline_id = :deadlineID");
            $statement->bindValue(":deadlineID", $this->m_sDeadlineID);
            $statement->execute();
    }

    public function deleteTask(){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("DELETE FROM deadlines WHERE deadline_id = :deadlineID");
            $statement->bindValue(":deadlineID", $this->m_sDeadlineID);
            $statement->execute();
    }

    public function updateTask(){
            $deadlineID = $_GET['Task'];
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("UPDATE deadlines SET titel = :titel, vak = :vak, datum = :datum, werkdruk = :werkdruk WHERE deadline_id = :deadlineID");
            $statement->bindparam(":titel", $this->m_sTitel);
            $statement->bindparam(":vak", $this->m_sVak);
            $statement->bindparam(":datum", $this->m_iDatum);
            $statement->bindValue(":deadlineID", $deadlineID);
            $statement->bindValue(":werkdruk", $this->m_sWerkdruk);
            $statement->execute();
    }
}
?>



