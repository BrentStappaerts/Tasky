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

?>
