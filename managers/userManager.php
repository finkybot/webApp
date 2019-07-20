<?php

	require_once '../classes/client.php';
	require_once '../classes/mysql.php';
	session_start();

	echo '<body style="background-color:SlateGrey">'; 
	echo '<div style ="font: 400 18px/1.8 Lato, sans-serif; color:AntiqueWhite">';
	echo "<hr/> <h1>Connecting to server</h1> <hr/>";

	$aClient = unserialize((base64_decode($_SESSION['clientSession'])));
	if(isset($_POST['loggedout'])) // if the user is trying to log out
	{
			if($aClient)
			{
					$aClient->userLogOut();
					unset($aClient);
			}
			header("location: https://tm470gap/index.html");
	}
	else
	{
		echo "<p> validate user login </p>";
		// check username and password fields on the login have data
		if($_POST && !empty($_POST['username']) && !empty($_POST['pwd']))
		{
			$mysql = new Mysql(1);

			$usrId = $_POST['username'];
			$pwd = $_POST['pwd'];
			
			//echo password_hash($pwd, PASSWORD_BCRYPT);
			$result = $mysql->verifyUser($usrId, $pwd);
				
			if($result)
			{
				if(strcmp($result, 'CLIENT') == 0)
				{
					$_SESSION['status'] = 'authorized';

					$aClient = new Client($usrId, $result); // create a new Client object
					$srlClient = base64_encode(serialize($aClient));   // serialize the Client ojbect
					$_SESSION['clientSession'] = $srlClient;    // pass the serialised object into the session
					$_SESSION['imageNum'] = 0;

					header("location: https://tm470gap/menus/clientMenu.php"); // move to client menu
				}

				if(strcmp($result, 'ADMIN') == 0)
				{
					$_SESSION['status'] = 'authorized';

					$aClient = new Admin($usrId, $result); // create a new Admin object
					$srlClient = base64_encode(serialize($aClient));   // serialize the Admin object
					$_SESSION['clientSession'] = $srlClient;    // pass the serialised object into the session
					$_SESSION['imageNum'] = 0;

					header("location: https://tm470gap/menus/adminMenu.php");  // move to the admin menu
				}
			}
			else 
			{
				unset($mysql);
				echo "<p> User login Failed</p>";
				header( "refresh:1;url=https://tm470gap/index.html" );
			}
		}    
	}