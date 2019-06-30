<?php
/* php calls files from the calling file location e.g. a root include ' classes/images.php' would work but the same call below
would fail for deeper dirs as the address would be appended as such /dir/classes/images.php so I need to ensure these are 
absolute addresses for the classes and includes */
$root = realpath($_SERVER["DOCUMENT_ROOT"]);    
require_once $root . '/classes/image.php';      
require_once $root . '/classes/mysql.php';      

    class Client
    {
        // Class variables
        private $user;
        private $imageLocation;
        private $admin;

        // array for holding objects
        private $images;

        // validateUser()
        // checks if user is valid
        function validateUser($usrId, $pwd)
        {
            $mysql = new Mysql();
            $this->accountType = false;

            $temp = $pwd . $usrId;
            $temp = md5($temp);
            $pwd = $temp . $pwd;
            $result = $mysql->verifyUnamePwd($usrId, sha1($pwd));

            if($result)
            {
                $_SESSION['status'] = 'authorized';

                // set the class variables
                $this->user = $usrId;
                $this->imageLocation = $result[0];
                $this->admin = $result[1];
     
                $this->images       =       $this->setupImageList();
                // set data into an array

                return true;
            }
            else return false;
        }


        // setupImageList()
        // fetch the images for the client
        function setupImageList()
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

        // get account type is this an admin or normal client
        function getAccountType()
        {
            return $this->admin;
        }
    }


