<?php
    // MESS CODE FOR TESTING ONLY AT THE MOMENT
    // create user account (I will have to consider how to handle accounts that may already exit)
    // The aim here is to carry out the following activities, note this will be a mess so I may sort this later
    // create a folder for the user eg /abrahamG/
    // upload the orginal image (Gillian should be able to select it) to the new folder, numerate it e.g abraham01.jpg
    // create a preview folder, 'pre'
    // create the preview watermarked images into the preview 'pre' folder
    // add the details to the database image table, (main image name, preview image name, main location, preview loacation and client the belong to)

       require_once 'classes/clients.php';
    require_once 'includes/functions.php';
    session_start();

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

      $mask = umask(0); // set the rights mask to 0 so I can create a folder with read, write and execute (777)
      //if (!is_dir($loc .'pre'))  // not needed on the virtual machine
      //{
          mkdir($loc . 'pre', 0777, true);
      //}
      umask($mask); // put folder mask back on

        $preLoc = $loc . "pre/PRE"; // locate the folder and addmendium for each image 'PRE'
        $image = $account->getImage($current);
        $myImage = $image->LoadJpeg($loc . $image->getFileName(), 'img/logo.png');
        
        // read jpeg image into buffer for displaying, remember files being read from outside of root folder
        header('Content-Type: text/jpeg');

        imagejpeg($myImage, ($preLoc . $image->getFileName()));  // NOTE: --- code combining and saving new image, FOR CREATING IMAGES ---
        
        readfile($preLoc . $image->getFileName());
        imagedestroy($myImage); // free the memory by destroying the image

    }