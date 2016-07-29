<?php

include_once "Db.class.php";

class Comment
{
	private $m_sComment;
    private $m_sCommentID;
    
    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty){
            case "Comment":
                $this->m_sComment = $p_vValue;
                break;
            case "CommentID":
                $this->m_sCommentID = $p_vValue;
                break;
        }
    }
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Comment":
                return $this->m_sComment;
                break;
            case "CommentID":
                return $this->m_sCommentID;
                break;
        }
    }
    public function Add() {
        if(!empty($this->m_sComment)){
            $PDO = Db::getInstance();
            $statement = $PDO->prepare("INSERT INTO comment (comment, userID) values (:comment, :userID)");
            $statement->bindValue(":comment", $this->m_sComment);
            $statement->bindParam(":userID", $_SESSION['user_id']);
            $statement->execute();
        }
        else {
            throw new Exception("Please fill in all fields");
        }
    }


}

?>