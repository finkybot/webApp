<?php
  require_once '../../classes/client.php';
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

		$clients = $admin->getClientList();
		$current = $_POST['cClient'];
		$aClient = $clients[$current];
		$admin->setCurrentClient($aClient);
		$srlClient = base64_encode(serialize($admin));   // serialize the Client ojbect
		$_SESSION['clientSession'] = $srlClient;    // pass the serialised object into the session

		echo'	<table cellpadding="30" id="tData"><tr><td>
		<p><h3 style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white">' . $aClient->getUser() . '</p><td><tr></table>';

		$row = 0;
		$currentFile = 0;
		$size = $aClient->getSizeOfImageArray();
		echo'	<table cellpadding="30" id="tData2"><tr><td>';
		while($row<=($size/4))
		{
			$column = 0;
			echo "<tr>";
			while($column<= 3)
			{
				if ($currentFile < $size)
				{
					echo '<td>';
					echo '<img src="../../managers/imageLoader.php?val=' . $currentFile . '" style="max-width: 150px; max-height: 150px; object-fit: contain"/>';
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
		echo '</table>
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

