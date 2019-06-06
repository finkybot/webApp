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
  $location = $account->getloc(); // retrieve the directory of the clients images
    
  //$images = $account->getImageArray();
  $images = $account->getPreviewArray();

  //if($_SESSION['imageNum'] < 0){$_SESSION['imageNum'] = 0;}
  if($_SESSION['imageNum'] < 0){$_SESSION['imageNum'] = sizeof($images)-1;}
  if($_SESSION['imageNum'] >= sizeof($images)){$_SESSION['imageNum'] = 0;}


  echo'
  <body>
    <div class="floating-menu">
      <form action="imageSelect.php" method="post">
      <div class="menu"><button  type="submit" name="down" value="DWN">Select previous Image</button></div>
      <div class="menu"><button  type="submit" name="up" value="UP">Select Next Image</button></div>
      </form>
    </div>

    <div class="floatb-menu">
    <form action="action.php" method="post">
    <div class="menu"><button  type="submit" name="loggedout">Log out</a></div>
    <div class="menu"> <span class="border">' . str_replace("PRE","",$images[$_SESSION['imageNum']]->getFileName()) . '</span></div>
    </form>
  </div>
    
    <div>
      <div class="caption" style="top: 10%">
        <div><img src="imageLoader.php?val=' . $_SESSION['imageNum'] . '" style="max-width: 98vw; max-height: 98vh; object-fit: contain"/></div>
      </div>
    </div>
  </body>
  </html>';
