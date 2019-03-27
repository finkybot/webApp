<?php
    session_start();
    require_once 'classes/clients.php';
    $account = new Client();
    $account->confirmClient();
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Gillian Abraham Photography</title>
  <meta name="description" content="Gillian Abraham Photography">
  <meta name="Keith Abraham" content="Photography">

  <link rel="stylesheet" href="css/styles.css">
  
</head>
<?php
    require_once 'includes/functions.php';
    $loc = $_SESSION['location'];
    $files = getDirectoryList($loc);
    $_SESSION['imgloc'] = $loc;

  echo '<body>
            <div class="mainPar"><div class="caption" style="top: 10%"> <span class="border">Client image download section</span></div>
            <div class="caption" style="top: 20%">';
            createTable('<table id="tData"',$loc ,$files);          
  echo      '</span></div></div>
            <div class="content" style="top: 5% !important"><h3 style="text-align: center;">Select your images for downloading</h3>
            <p>Downloaded images go here, users will be able to select and download from any image made available here.<br/>
            <a href="action.php?status=loggedout">Log out</a></p>
        </body>';
?>
</html>