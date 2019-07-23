<?php
  require_once '../../classes/client.php';
  require_once '../../classes/mysql.php';
  session_start();
  
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
		</head>
		<body>';

		if(isset($_POST['cClient']))
		{
			$clients = $admin->getClientList();
			$current = $_POST['cClient'];
			$aClient = $clients[$current];
			$size = $aClient->getSizeOfImageArray();

			$admin->setCurrentClient($aClient);
			$srlClient = base64_encode(serialize($admin));   // serialize the Client ojbect
			$_SESSION['clientSession'] = $srlClient;    // pass the serialised object into the session
		}
		else 
		{
			$aClient = $admin->getCurrentClient();
			$size = $aClient->getSizeOfImageArray();
			$imageFiles = $_POST['status'];
			$i	=	0;
			while($i < $size)
			{
				if(in_array($aClient->getImageFromArray($i)->getFileName(), $imageFiles))
				{
			    $admin->changeImageStatus(1, $aClient->getImageFromArray($i));
				}
				else
				{
					$admin->changeImageStatus(0, $aClient->getImageFromArray($i));
				}	
				$i++;
			}
			$srlClient = base64_encode(serialize($admin));   // serialize the Client ojbect
			$_SESSION['clientSession'] = $srlClient;    // pass the serialised object into the session
		}    
    echo'<table>
    <form method="post" action="">
    
    <tr><td style="text-align: right; padding: 15px"><label><h5 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white">Username</label>
    <input type="text" placeholder=' . $aClient->getUser() . ' name="username" required></td></tr>

    <tr><td style="text-align: right; padding: 15px"><label><h5 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white">Enter new password</label>
    <input type="password" placeholder="Enter Password" id="pwd" required></td>
    
    <td style="text-align: right; padding: 15px"><label><h5 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white">Re-enter new password</label>
    <input type="password" placeholder="Enter Password" id="conPwd" required></td>
    <td><button  type="submit" name="submit" >Submit</button></div></td></tr>
    </form>    
    </table>
    
    <script>
    var pwd = document.getElementById("pwd"), confirmPwd = document.getElementById("conPwd");
    function validatePassword()
    {
      if(pwd.value != confirmPwd.value) 
      {
        confirmPwd.setCustomValidity("Passwords do not match");
      } 
      else 
      {
        confirmPwd.setCustomValidity(\'\');
      }
    }
    pwd.onchange = validatePassword;
    confirmPwd.onkeyup = validatePassword;
    </script>';

		$row = 0;
		$currentFile = 0;
    echo '<table cellpadding="30" id="tData">';
    echo '<form action="clientEdit.php" id="imageStat" method="post">';
		while($row<=($size/4))
		{
			$column = 0;
			echo "<tr>";
			while($column <= 3)
			{
				if ($currentFile < $size)
				{
					echo '<td>';
					echo '<br><h5 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white">' . $aClient->getImageFromArray($currentFile)->getFileName();
					echo '<img src="../../managers/imageLoader.php?val=' . $currentFile . '" style="max-width: 100%; max-height: 100%; object-fit: contain"/>';
					echo '<br>';

					if($aClient->getImageFromArray($currentFile)->getStatus() == 1)
					{
						echo '<h5 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white"><input type="checkbox" name="status[]" value="'
														. $name = $aClient->getImageFromArray($currentFile)->getFileName() .'" checked>Purchased status';
					}
					else 
					{
						echo '<h5 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white"><input type="checkbox" name="status[]" value="'
														. $name = $aClient->getImageFromArray($currentFile)->getFileName() . '">Purchased status';
					}
					echo '</td>';
				}
				else 
				{
					echo '<td> </td>';
				}
				$currentFile++;
				$column++;
			}
			echo "</tr>";
			$row++;
		}
		echo '</form>';
		echo '</table>';
		echo '
			<div class="floatb-menu">
			<form action="../../managers/userManager.php" method="post"><div class="menu"><button  type="submit" name="loggedout">Log out</button></div></form>
			<div class="menu"> <span class="border">' . $admin->getUser() . '</span></div>
			<button  type="submit" name="submit" form="imageStat">Update image status</button></div>
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

