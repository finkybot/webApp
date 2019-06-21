<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]); 
require_once  $root . '/classes/mysql.php';

    class Image
    {
        // Class variables
        private $client;
        private $fileName;

        function __construct($aClient, $aFileName)
        {
           $this->client = $aClient;
           $this->fileName = $aFileName;
        }

function loadImage($location)
        {
            $myImage = $this->LoadJpeg($location . $this->getFileName(), 'img/logo.png');

           // $mDir = getcwd(); // get the current main dir for safe keeping

            printf($location);
            printf($this->getFileName());

            return $myImage;
            
            // read jpeg image into buffer for displaying, remember files being read from outside of root folder
            //header('Content-Type: image/jpeg');
            
            //chdir($location); // set dir to client hidden dir

            //imagejpeg($myImage, 'tempImage.jpg'); 
            
            //chdir($mDir); // reset dir
           
            //imagedestroy($myImage);
        }

        function LoadJpeg($imgname, $theStamp)
        {
            // Open both the jpg images
            $mainImage = imagecreatefromjpeg($imgname);
            $stamp = imagecreatefrompng($theStamp);
            
            // See if the mainImage jpg or stamp png loading fails then return null
            if(!$mainImage || !$stamp)
            {
                return null;
            }
    
            // Set the margins for the stamp
            $marginX = 110;
            $marginY = 120;

            // get the image size of the stamp
            $imageX = imagesx($stamp);
            $imageY = imagesy($stamp);

            // 
            imagecopy($mainImage, $stamp, imagesx($mainImage) - $imageX + $marginX, imagesy($mainImage) - $imageY + $marginY, 0, 0, imagesx($stamp), imagesy($stamp));
            return $mainImage;
        }

        // helpers get the file name
        function getFileName()
        {
            return $this->fileName;
        }

        // helpers get the client name
        function getClientName()
        {
            return $this->fileName;
        }
    }


