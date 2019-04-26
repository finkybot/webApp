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
    
  $images = $account->getImageArray();

  //if($_SESSION['imageNum'] < 0){$_SESSION['imageNum'] = 0;}
  if($_SESSION['imageNum'] < 0){$_SESSION['imageNum'] = sizeof($images)-1;}
  if($_SESSION['imageNum'] >= sizeof($images)){$_SESSION['imageNum'] = 0;}


  echo'
  <body>
    <div class="floating-menu">
      
      <div class="menu"><a href="action.php?status=loggedout">Log out</a></div>
      <div class="menu"><a href="dummy">Place holder 1</a></div>
      <div class="menu"><a href="dummy">Place holder 2</a></div> 
    </div>
    
    <div>
      <div class="caption" style="top: 10%"> <span class="border">' . $images[$_SESSION['imageNum']]->getFileName() . '</span></div>
      <div class="caption" style="top: 20%">
          
        <table id="tData">
        <form action="/imageSelect.php" method="post">
          <tr><td><button class="button buttonMov" type="submit" name="up" value="UP">100%</button></td></tr>
          <tr><td><img src="imageLoader.php?val=' . $_SESSION['imageNum'] . '" style="max-width: 80vw; max-height: 80vh; object-fit: contain"/></td></tr>
          <tr><td><button class="button buttonMov" type="submit" name="down" value="DWN">100%</button></td></tr>
        </form>
        </table>
      </div>
    </div>
  </body>
  </html>';
