<?php
  require_once '../classes/client.php';
  session_start();

  // check a client object has been made
  $aClient = unserialize((base64_decode($_SESSION['clientSession'])));
  if($aClient && strcmp($aClient->getAccountType(), 'ADMIN') == 0) // check admin is logged in
  {
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
  <?php
    <body>
      <div class="floatb-menu">
          <form action="../managers/userManager.php" method="post"><div class="menu"><button  type="submit" name="loggedout">Log out</a></div></form></div>


      <div class="caption top">
          <form action="imageview/viewer.php" method="post"><div class="menu"><button class="mainButton" type="submit" name="setup account">SETUP CLIENT ACCOUNT</button></div></form>
      </div>

      <div class="caption mid">
      <form action="imageview/viewer.php" method="post"><div class="menu"><button class="mainButton" type="submit" name="edit account">EDIT CLIENT ACCOUNT</button></div></form>
  </div>

      <div class="caption bot">
        <form action="imageview/viewer.php" method="post"><div class="menu"><button class="mainButton" type="submit" name="manage images">MANAGE IMAGE UPLOADS</button></div></form>
      </div>
  </body>
  </html>';
  }
  else 
  {
    if($aClient)
    {
      $aClient->userLogOut();
      unset($aClient);
    }
    header('location: https://tm470gap/index.html');
    exit;
  }

