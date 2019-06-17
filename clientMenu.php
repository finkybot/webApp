<?php
    require_once 'classes/client.php';
    require_once 'includes/functions.php';
    session_start();

    // Make sure we have a canary set
    if (!isset($_SESSION['canary'])) 
    {
      session_regenerate_id(true);
      $_SESSION['canary'] = time();
    }

    // check a client object has been made
    $aClient = unserialize((base64_decode($_SESSION['clientSession'])));
    if(!$aClient) // if now client object is found then the user isnt correctly logged in
    {
      header('location: index.html');
      exit;
    }
?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Gillian Abraham Photography</title>
      
<meta name="description" content="Gillian Abraham Photography">
<meta name="Keith Abraham" content="Photography">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/styles2.css">


</head>
<?php


  echo'
    <body>
      <div class="floating-menu">
          <form action="preview.php" method="post"><div class="menu"><button  type="submit" name="Preview images" value="DWN">Select Image Previewer</button></div></form></div>

      <div class="floatb-menu">
          <form action="userManager.php" method="post"><div class="menu"><button  type="submit" name="loggedout">Log out</a></div></form></div>


      <div class="caption top">
          <form action="preview.php" method="post"><div class="menu"><button class="mainButton" type="submit" name="Preview images">PREVIEW ALL IMAGES</button></div></form>
      </div>

      <div class="caption bot">
        <form action="adminMenu.php" method="post"><div class="menu"><button class="mainButton" type="submit" name="Download images">VIEW AND DOWNLOAD PURCHASED PHOTOS</button></div></form>
      </div>
  </body>
  </html>';
