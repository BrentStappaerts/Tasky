<?php
    include_once "Db.class.php";

    class User
    {
        private $m_sEmail;
        private $m_sName;
        private $m_sPassword;



        function __SET($p_sProperty, $p_vValue)
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
            }
        }

        function __GET($p_sProperty)
        {
            switch( $p_sProperty){
                case "Email":
                    return $this->m_sEmail;
                    break;
                case "Name":
                    return $this->m_sName;
                    break;
                case "Password":
                    return $this->m_sPassword;
                    break;
            }
        }

        public function register(){
            $conn = Db::getInstance();

            $statement = $conn->prepare('INSERT INTO user (email,name,password) VALUES  ( :email,:name,:password)');
            $statement->bindValue(':email',$this->Email);
            $statement->bindValue(':name',$this->Name);
            $statement->bindValue(':password',$this->Password);
            $statement->execute();
        }

        public function login($s_name, $s_password){
            try
            {
                $conn = Db::getInstance();
                $statement = $conn->prepare("SELECT * FROM user WHERE name=:name");
                $statement->bindValue(':name',$this->Name);
                $statement->execute();
                $userRow=$statement->fetch(PDO::FETCH_ASSOC);
                if($statement->rowCount() > 0)
                {
                    if(password_verify($p_password, $userRow['password']))
                    {
                        session_start();
                        $_SESSION['loggedin'] = "ja";
                        $_SESSION['name'] = $s_Name;
                        $_SESSION['userID'] = $userRow['id'];
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

    }

?>
