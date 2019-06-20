<?php
  require_once 'menus/classes/client.php';
  require_once 'menus/includes/functions.php';
  session_start();

  // Make sure we have a canary set
  if (!isset($_SESSION['canary'])) 
  {
    session_regenerate_id(true);
    $_SESSION['canary'] = time();
  }

  // check a client aClient has be in
  $aClient = unserialize((base64_decode($_SESSION['clientSession'])));
  if(!$aClient)
  {
    header('location: index.html');
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

    <link rel="stylesheet" href="../css/styles3.css">
    </head>';

  $images = $aClient->getPreviewArray();

  if(isset($_POST['up']))
  {
      $_SESSION['imageNum']++;
  }    

  if(isset($_POST['down']))
  {
      $_SESSION['imageNum']--;
  }    

  //if($_SESSION['imageNum'] < 0){$_SESSION['imageNum'] = 0;}
  if($_SESSION['imageNum'] < 0){$_SESSION['imageNum'] = sizeof($images)-1;}
  if($_SESSION['imageNum'] >= sizeof($images)){$_SESSION['imageNum'] = 0;}


  echo'
    <body>
      <div class="floating-menu">
        <form action="preview.php" method="post">
          <div class="menu"><button  type="submit" name="down" value="DWN">Select previous Image</button></div>
          <div class="menu"><button  type="submit" name="up" value="UP">Select Next Image</button></div>
        </form>
      </div>

      <div class="floatb-menu">
        <form action="userManager.php" method="post">
          <div class="menu"><button  type="submit" name="loggedout">Log out</a></div>
        </form>
        <form action="menus/clientMenu.php" method="post">
          <div class="menu"><button  type="submit" name="return">Return to menu</button></div>
        </form>
        <div class="menu"> <span class="border">' . str_replace("PRE","",$images[$_SESSION['imageNum']]->getFileName()) . '</span></div>
      </div>
      
      <div>
        <div class="caption" style="top: 10%">
          <div><img src="previewLoader.php?val=' . $_SESSION['imageNum'] . '" style="max-width: 98vw; max-height: 98vh; object-fit: contain"/></div>
          <button class="menu fsButton" id="btnFullscreen" type="button">Toggle Fullscreen</button>
        </div>
      </div>
      <script src="scripts/fullscreen.js"></script>
    </body>
    </html>';
