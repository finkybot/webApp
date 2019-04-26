<?php
    session_start();
    require_once 'classes/clients.php';
    require_once 'includes/functions.php';

    //$account = new Client();
    $account = unserialize((base64_decode($_SESSION['clientSession'])));
    if(!$account)
    {
      header('location: index.html');
      exit;
    }


  echo '<!doctype html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>Gillian Abraham Photography</title>
      
          <meta name="description" content="Gillian Abraham Photography">
          <meta name="Keith Abraham" content="Photography">
          <meta name="viewport" content="width=device-width, initial-scale=1">
  
          <link rel="stylesheet" href="css/styles2.css">
  
      </head>';

  $loc = $account->getloc(); // retrieve the directory of the clients images
      //$imageSum = $account->getSizeOfImageArray(); // retrieve a count of the number of images linked to the client
    
  $images = $account->getImageArray();

echo  '<body>
        <div class="floating-menu">
          <div class="menu"><a href="action.php?status=loggedout">Log out</a></div>
          <div class="menu"><a href="dummy">Place holder 1</a></div>
          <div class="menu"><a href="dummy">Place holder 2</a></div> 
        </div>
        <div>
          <div class="caption" style="top: 10%"> <span class="border">Client image preview section</span></div>
          <div class="caption" style="top: 20%">';
      createTable('<table id="tData"', $loc, $images); 
      echo     '</span></div></div>
        </body>
        </html>';