<?php
  require_once  '../classes/client.php';
  require_once  '../includes/functions.php';
  session_start();

  // Make sure we have a canary set
  if (!isset($_SESSION['canary'])) 
  {
    session_regenerate_id(true);
    $_SESSION['canary'] = time();
  }

  // check a client object has been made
  $aClient = unserialize((base64_decode($_SESSION['clientSession'])));
  if(!$aClient || $aClient->getAccountType() != 0) // check if a client is logged in
  {
    if($aClient)
    {
      $aClient->userLogOut();
      unset($aClient);
    }
    header('location: https://tm470gap/index.html');
    exit;
  }
  echo'
    <!doctype html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Gillian Abraham Photography</title>
          
    <meta name="description" content="Gillian Abraham Photography">
    <meta name="Keith Abraham" content="Photography">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../css/styles2.css">

    </head>
    <body>
      <div class="floatb-menu">
          <form action="../managers/userManager.php" method="post"><div class="menu"><button  type="submit" name="loggedout">Log out</a></div></form></div>


      <div class="caption own">
        <form action="imageview/viewer.php" method="post"><div class="menu"><button class="mainButton" type="submit" name="Download images">PRESS HERE TO VIEW YOUR PHOTOS</br>DOWNLOAD YOUR PURCHASED PHOTOS</button></div></form>
        <p><h2 style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black">
        Purchased images will not be watermarked<br>and can be downloaded by clicking<br>or pressing the image<h2></p>
      </div>
  </body>
  </html>';
