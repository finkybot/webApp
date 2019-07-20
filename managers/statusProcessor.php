<?php
	require_once '../classes/client.php';
	require_once '../classes/mysql.php';
	session_start();

	// ensure user is logged in
	$admin = unserialize((base64_decode($_SESSION['clientSession'])));
	if(!$admin || strcmp($admin->getAccountType(), 'ADMIN') != 0)
	{
		header('location: https://tm470gap/index.html');
		exit;
	}

	$user = $_POST['user'];
	$imageName = $_POST['imageName'];

	// fetch a passed value to find current image 
	$aClient = $admin->getClientFromList();
	$loc = $aClient->getImageLocation() . "/";

	// get current image and display it on the website
	$image = $aClient->getImageFromArray(0);
	$file = $loc . $image->getFileName();
	if (file_exists($file) && $image->getStatus() == 1) 
	{
			header('Content-Description: File Transfer');
			header('Content-Type: text/jpeg');
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); // save the file under its orginal name with the file location removed
			header('Expires: 0');
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean(); // clean the output buffer before reading file
			readfile($file);
			exit;
	}
