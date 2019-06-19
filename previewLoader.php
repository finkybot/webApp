<?php
    // really wanted to place this code in a class but loading images into browsers appears to be problematic
    // so for the time being I am using a php page to carry out image loading, I might update this to a 
    // method called by jquery at a later date
    require_once 'menus/classes/client.php';
    //require_once 'includes/functions.php';
    session_start();

    // ensure user is logged in
    $account = unserialize((base64_decode($_SESSION['clientSession'])));
    if(!$account)
    {
      header('location: https://tm470gap/index.html');
      exit;
    }

    // fetch a passed value to find current image 
    $loc = $account->getPrevLoc() . "/";
    $current = $_GET['val'];
    if(is_numeric($current))
    {
        
        // get current image and display it on the website
        //$image = $account->getImage($current);
        $image = $account->getPreview($current);
        header('Content-Type: text/jpeg');
        readfile($loc . $image->getFileName());
    }