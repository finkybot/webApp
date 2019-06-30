<?php
    // really wanted to place this code in a class but loading images into browsers appears to be problematic
    // so for the time being I am using a php page to carry out image loading, I might update this to a 
    // method called by jquery at a later date
    require_once '../classes/client.php';
    //require_once 'includes/functions.php';
    session_start();

    // ensure user is logged in
    $aClient = unserialize((base64_decode($_SESSION['clientSession'])));
    if(!$aClient)
    {
      header('location: https://tm470gap/index.html');
      exit;
    }

    // fetch a passed value to find current image 
    $loc = $aClient->getImageLocation() . "/";
    $current = $_GET['val'];
    if(is_numeric($current))
    {
        // get current image and display it on the website
        $image = $aClient->getImageNameFromArray($current);
        if($image->getStatus() == 1)
        {
          header('Content-Type: text/jpeg');
          readfile($loc . $image->getFileName());
        }
        else
        {
          $myImage = $image->createWatermarkedImage($loc . $image->getFileName(), '../img/logo.png');
          header('Content-Type: text/jpeg');
          imagejpeg($myImage); 
          imagedestroy($im);
        }
    }