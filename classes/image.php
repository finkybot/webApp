<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]); 
require_once  $root . '/classes/mysql.php';

class Image
{
	// Class variables
	private $client;
	private $fileName;
	private $status;

	function __construct($aClient, $aFileName, $stat)
	{
		$this->client = $aClient;
		$this->fileName = $aFileName;
		$this->status = $stat;
	}

	function createWatermarkedImage($imgname, $theStamp)
	{
		// Open both the jpg images
		$mainImage = imagecreatefromjpeg($imgname);
		$stamp = imagecreatefrompng($theStamp);
		
		// See if the mainImage jpg or stamp png loading fails then return null
		if(!$mainImage || !$stamp)
		{
				return null;
		}

		// get the image size of the stamp
		$imageX = imagesx($stamp);
		$imageY = imagesy($stamp);
		// Set the margins for the stamp
		$marginX = (imagesx($mainImage)/2)-($imageX/2);
		$marginY = (imagesy($mainImage)/2)-($imageY/2);

		imagecopy($mainImage, $stamp, imagesx($mainImage) - $imageX - $marginX, imagesy($mainImage) - $imageY - $marginY, 0, 0, imagesx($stamp), imagesy($stamp));
		return $mainImage;
	}

	// helpers get the file name
	function getFileName()
	{
		return $this->fileName;
	}

	// helpers get the client
	function getClient()
	{
		return $this->client;
	}

	// helpers get the status
	function getStatus()
	{
		return $this->status;
	}
}


