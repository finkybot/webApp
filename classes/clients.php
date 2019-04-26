<?php

require_once 'classes/images.php';
require_once 'classes/mysql.php';

    class Client
    {
        // Class variables
        private $user;
        private $password;
        private $imageLocation;
        private $status;

        // array for holding objects
        private $images;

        // validateUser()
        // checks if user is valid
        function validateUser($usrId, $pwd)
        {
            $mysql = new Mysql();
            $result = $mysql->verifyUnamePwd($usrId, md5($pwd));

            if($result)
            {
                $_SESSION['status'] = 'authorized';
                $_SESSION['location'] = $result;

                // set the class variables
                $this->user = $usrId;
                $this->password = $pwd;
                $this->imageLocation = $result;
                $this->status = true;

                $this->getImageList();
                // set data into an array

                return true;
            }
            else return false;
        }

        // getImageList()
        // get the images for the client
        function getImageList()
        {
            $mysql = new Mysql();
            $result = $mysql->getImageLists($this->user);

            $this->images = array();

            foreach ($result as $value)
            {
                $tempImage = new Image($this->user, $value);
                array_push($this->images, $tempImage);
            }
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
                    unset($_COOKIE[session_name()]); // unset default cookie
                    setcookie (session_name(), "", time()-3600); // set any default cookie to expire in a prior time
                    session_destroy();  // kill the session
                }
            }
        }

        // confirmClient()
        // confirms a client is logged in
        //function confirmClient()
        //{
        //    session_start();
            //echo "<p>username or password not recognised </p>";
            //if($_SESSION['status'] != 'authorized') 
        //    return $this->status;
        //}

        // getter helper functions
        // get user
        function getUser()
        {
            return $this->user;
        }

        // get the password
        function getPwd()
        {
            return $this->password;
        }

        // get the password
        function getLoc()
        {
            return $this->imageLocation;
        }

        // get the image out of the array
        function getImage($i)
        {
            return $this->images[$i];
        }

        // get the image array
        function getImageArray()
        {
            return $this->images;
        }

        // return the size of the image array
        function getSizeOfImageArray()
        {
            return sizeof($this->images);
        }

    }


