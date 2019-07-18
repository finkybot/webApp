<?php
  require_once '../../classes/client.php';
  session_start();
  
  $screenWidth = $_POST['screenSize'];
  // check a client aClient has be in
  $admin = unserialize((base64_decode($_SESSION['clientSession'])));
  if($admin && strcmp($admin->getAccountType(), 'ADMIN') == 0)
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

      <link rel="stylesheet" href="../../css/styles3.css">
      </head>';
    echo'
      <body>
      <table cellpadding="30" id="tData">'; 
      $row = 0;
      $currentVal = 0;
      $clients = $admin->getClientList();
      $size = sizeof($clients);
      
      while($row<=($size/4))
      {
          $column = 0;
          echo "<tr>";
          while($column<= 3)
          {
              if ($currentVal < $size)
              {
                  $aClient = $clients[$currentVal];
                  echo '<td>';
                  echo '<form action="clientEdit.php" method="post">';
                  echo '<div class="menu"><button class="mainButton" type="submit" name="setup account">
                        <p><h3 style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black">' . $aClient->getUser() . 
                        '</p>' . '</button></div>
                        <input type="hidden" name="cClient" id="cClient" value="' . $currentVal . '">
                        </form>';
                  echo '</td>'; 
              }
              else 
              {
                  echo '<td> </td>';
              }
              $currentVal++;
              $column++;
          }
          echo "</tr>";
          $row++;
      }
    echo'
      </table>
      </div>
      <div class="floatb-menu">
        <form action="../../managers/userManager.php" method="post"><div class="menu"><button  type="submit" name="loggedout">Log out</a></div></form>
        <div class="menu"> <span class="border">' . $admin->getUser() . '</span></div></div>
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

