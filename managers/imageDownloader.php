<?php
    // really wanted to place this code in a class but loading images into browsers appears to be problematic
    // so for the time being I am using a php page to carry out image loading, I might update this to a 
    // method called by jquery at a later date
    require_once '../classes/client.php';
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

    // get current image and display it on the website
    $image = $aClient->getImageNameFromArray($_SESSION['imageNum']);
    $file = $loc . $image->getFileName();
    if (file_exists($file) && $image->getStatus() == 1) 
    {
        header('Content-Description: File Transfer');
        header('Content-Type: text/jpeg');
        header('Content-Disposition: attachment; filename="'.basename($file).'"'); // save the file under its orginal name with the file location removed
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean(); // clean the output buffer before reading file
        readfile($file);
        exit;
    }
