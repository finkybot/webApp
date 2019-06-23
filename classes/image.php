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

        function createWatermarkedImage($imgname, $theStamp)
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

            imagecopy($mainImage, $stamp, imagesx($mainImage) - $imageX + $marginX, imagesy($mainImage) - $imageY + $marginY, 0, 0, imagesx($stamp), imagesy($stamp));
            return $mainImage;
        }

        // helpers get the file name
        function getFileName()
        {
            return $this->fileName;
        }

        // helpers get the client
        function getClient()
        {
            return $this->client;
        }
    }


