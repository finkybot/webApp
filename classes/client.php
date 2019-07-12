<?php
/* php calls files from the calling file location e.g. a root include ' classes/images.php' would work but the same call below
would fail for deeper dirs as the address would be appended as such /dir/classes/images.php so I need to ensure these are 
absolute addresses for the classes and includes */
$root = realpath($_SERVER["DOCUMENT_ROOT"]);    
require_once $root . '/classes/image.php';      
require_once $root . '/classes/mysql.php';      
    class User
    {
        // Class variables
        private $user;
        private $imageLocation;
        private $userType;

        // array for holding objects
        private $images;

        // Constructor for Client
        function __construct($usrID, $stat)
        {
            $this->user = $usrID;
            $this->userType = $stat;

            // get the image folder location & image list
            $this->imageLocation    =       $this->setupLocation();
            $this->images           =       $this->setupImageList();
        }

        // setupLocation()
        // fetch the image folder location for the user
        private function setupLocation()
        {
            $mysql = new Mysql();
            return  $mysql->getFileLocation($this);  
        }


        // setupImageList()
        // fetch the images for the client
        private function setupImageList()
        {
            $mysql = new Mysql();
            $result = $mysql->getImageList($this->user);  
            $files = array();
            // $this->images = array();

            foreach ($result as $key => $value)
            {
                $tempImage = new Image($this->user, $key, $value);
                array_push($files, $tempImage);
                // array_push($this->images, $tempImage);
            }
            return $files;
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

        // getter helper functions
        // get user
        function getUser()
        {
            return $this->user;
        }

        // get the  main images location
        function getImageLocation()
        {
            return $this->imageLocation;
        }

        // get the image out of the array
        function getImageNameFromArray($i)
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

        // get account type is this an userType or normal client
        function getAccountType()
        {
            return $this->userType;
        }

        // getter helper functions
        // get MySQL connection
        private function getConn()
        {
            return $this->conn;
        }
    }


