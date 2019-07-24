<?php
  require_once '../../classes/client.php';
  require_once '../../classes/mysql.php';
  session_start();
  
  // check a client aClient has be in
  $admin = unserialize((base64_decode($_SESSION['clientSession'])));
  if($admin && strcmp($admin->getAccountType(), 'ADMIN') == 0)
  { ?>
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
		<body>
<?php
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
			if(isset($_POST['status'])) // check if the user has posted image status updates
			{
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
			}
			elseif(isset($_POST['pwd'])) // check if user has modified the username
			{
				$password = $_POST['pwd'];
				if($admin->changeUserPwd($admin->getCurrentClient(),$password))
				{
					echo "<script type='text/javascript'>alert('Password updated')</script>";
				}
			}
			elseif(isset($_POST['username']))
			{
				$username = $_POST['username'];
				$mysql = new Mysql(NULL);
				if(!$mysql->verifyUname($username))
				{
					$admin->changeUserName($admin->getCurrentClient(),$username);
					echo "<script type='text/javascript'>alert('Username changed')</script>";
				}
				else 
				{
					echo "<script type='text/javascript'>alert('Username has not been changed')</script>";
				}
			}
			$srlClient = base64_encode(serialize($admin));   // serialize the Client ojbect
			$_SESSION['clientSession'] = $srlClient;    // pass the serialised object into the session
		}?>

 	<table>
    <form method="post" action="clientEdit.php">
    <tr><td class="td1"><label><h5>Username</label>
		<input type="text" placeholder= <?php echo $aClient->getUser(); ?> name="username" id="username" required></td><td></td>
		<td><button  type="submit" id="submitUser" disabled>Submit</button></div></td></tr>
	</form>

	<form method="post" action="clientEdit.php">
    <tr><td class="td1"><label><h5>Enter new password</label>
    <input type="password" placeholder="Enter Password" name="pwd" id="pwd" required></td>
    
    <td class="td1"><label><h5>Re-enter new password</label>
    <input type="password" placeholder="Enter Password" name="confirmPwd" id="confirmPwd" required></td>
    <td><button  type="submit" id="submitPwd" disabled>Submit</button></div></td></tr>
  </form>    
  </table>
    
  <script>
		var username = document.getElementById("username"), submitUser = document.getElementById("submitUser");
    var pwd = document.getElementById("pwd"), confirmPwd = document.getElementById("confirmPwd"), submitPwd = document.getElementById("submitPwd");
    function validatePassword()
    {
      if(pwd.value != confirmPwd.value) 
      {
				confirmPwd.setCustomValidity("Passwords do not match");
				submitPwd.disabled = true;
      } 
      else 
      {
				confirmPwd.setCustomValidity('');
				submitPwd.disabled = false;
      }
		}
		
		function validateUsername()
		{
			if(username.value.length < 5)
			{
				username.setCustomValidity("Username must have 6 or more characters");
				submitUser.disabled = true;
			}
			else
			{
				username.setCustomValidity("");
				submitUser.disabled = false;				
			}
		}

		username.onkeydown = validateUsername;
    pwd.onchange = validatePassword;
    confirmPwd.onkeyup = validatePassword;
  </script>

<?php
		$row = 0;
		$currentFile = 0; ?>

	<table cellpadding="30" id="tData">
	<form action="clientEdit.php" id="imageStat" method="post">
	
	<?php
		while($row<=($size/4))
		{
			$column = 0;
			echo "<tr>";
			while($column <= 3)
			{
				if ($currentFile < $size)
				{
					echo 	'<td><br><h5>' . $aClient->getImageFromArray($currentFile)->getFileName() . 
								'<img src="../../managers/imageLoader.php?val=' . $currentFile . '" style="max-width: 100%; max-height: 100%; object-fit: contain"/><br>';

					if($aClient->getImageFromArray($currentFile)->getStatus() == 1)
					{
						echo '<h5><input type="checkbox" name="status[]" value="'. $name = $aClient->getImageFromArray($currentFile)->getFileName() .'" checked>Purchased status';
					}
					else 
					{
						echo '<h5><input type="checkbox" name="status[]" value="'. $name = $aClient->getImageFromArray($currentFile)->getFileName() .'">Purchased status';
					}
					echo '</td>';
				}
				else 
				{
					echo '<td></td>';
				}
				$currentFile++;
				$column++;
			}
			echo "</tr>";
			$row++;
		}
?>
	</form>
	</table>
		<div class="floatb-menu">
		<form action="../../managers/userManager.php" method="post"><div class="menu"><button  type="submit" name="loggedout">Log out</button></div></form>
		<div class="menu"> <span class="border"> <?php echo $admin->getUser(); ?> </span></div>
		<button  type="submit" name="submit" form="imageStat">Update image status</button></div>
	</body>
	</html>

<?php
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

