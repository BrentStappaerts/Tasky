<?php

include_once "Db.class.php";

class Comment
{
	private $m_sComment;
    private $m_sCommentUsername;
    
    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty){
            case "Comment":
                $this->m_sComment = $p_vValue;
                break;
            case "CommentUsername":
                $this->m_sCommentUsername = $p_vValue;
                break;
        }
    }
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Comment":
                return $this->m_sComment;
                break;
            case "CommentUsername":
                return $this->m_sCommentUsername;
                break;
        }
    }
    public function Add() {
        if(!empty($this->m_sComment)){
            $deadlineID = $_GET['Task'];
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO comments (comment, userID, username, deadlineID) values (:comment, :userID, :username, :deadlineID)");
            $statement->bindValue(":comment", $this->m_sComment);
            $statement->bindValue(":userID", $_SESSION['user_id']);
            $statement->bindValue(":username", $this->m_sCommentUsername);
            $statement->bindValue(":deadlineID", $deadlineID);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }

    public function getAll(){
        $deadlineID = $_GET['Task'];
        $PDO = Db::getInstance();
        $statement = $PDO->prepare("SELECT * FROM comments WHERE deadlineID = :deadlineID");
        $statement->bindValue(":deadlineID", $deadlineID);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }


}

?>