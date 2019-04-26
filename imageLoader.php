<?php
    // really wantted to place this code in a class but loading images into browsers appears to be problematic
    // so for the time being I am using a php page to carry out image loading
    session_start();
    require_once 'classes/clients.php';
    require_once 'includes/functions.php';

    // ensure user is logged in
    $account = unserialize((base64_decode($_SESSION['clientSession'])));
    if(!$account)
    {
      header('location: index.html');
      exit;
    }

    // fetch a passed value to find current image 
    $loc = $account->getLoc() . "/";
    $current = $_GET['val'];
    if(is_numeric($current))
    {
        $image = $account->getImage($current);
        $myImage = $image->LoadJpeg($loc . $image->getFileName(), 'img/logo.png');
        
        // read jpeg image into buffer for displaying, remember files being read from outside of root folder
        header('Content-Type: text/jpeg');
        imagejpeg($myImage);
        imagedestroy($myImage);
    }