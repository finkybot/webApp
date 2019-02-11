<?php

require 'classes/mysql.php';

    class Client
    {
        // validateUser($userId, $pwd)
        // checks if user is valid
        function validateUser($usrId, $pwd)
        {
            $mysql = new Mysql();
            $result = $mysql->verifyUnamePwd($usrId, md5($pwd));

            if($result)
            {
                $_SESSION['status'] = 'authorized';
                return true;
            }
            else return false;
        }

        // userLogOut()
        // logs the user out and clears session
        function userLogOut()
        {
            if(isset($_SESSION['status']))
            {
                unset($_SESSION['status']);

                if(isset($_COOKIE[session_name()]))
                {
                    unset($_COOKIE[session_name()]);
                    setcookie (session_name(), "", time()-3600);
                    session_destroy();
                }
            }
        }

        // confirmClient()
        // confirms a client is logged in
        function confirmClient()
        {
            session_start();
            if($_SESSION['status'] != 'authorized') header("location: index.html");
        }
    }


