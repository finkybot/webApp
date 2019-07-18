<?php
/* php calls files from the calling file location e.g. a root include ' classes/images.php' would work but the same call below
would fail for deeper dirs as the address would be appended as such /dir/classes/images.php so I need to ensure these are 
absolute addresses for the classes and includes */
$root = realpath($_SERVER["DOCUMENT_ROOT"]);    
require_once $root . '/classes/image.php';      
require_once $root . '/classes/mysql.php';      
	
class User
{
	// Class variables
	protected $user;
	protected $userType;
	protected $imageLocation;

	// getter helper functions
	// get user
	public function getUser()
	{
		return $this->user;
	}
	
	// get account type is this an userType or normal client
	public function getAccountType()
	{
		return $this->userType;
	}

	// setupLocation()
	// fetch the image folder location for the user
	protected function setupLocation()
	{
		$mysql = new Mysql();
		return  $mysql->getFileLocation($this);  
	}

	// get the  main images location
	public function getImageLocation()
	{
		return $this->imageLocation;
	}

	// userLogOut()
	// logs the user out and clears session
	public function userLogOut()
	{
		if(isset($_SESSION['status']))
		{
			unset($_SESSION['status']);

			if(isset($_COOKIE[session_name()]))
			{
				unset($_COOKIE[session_name()]); // unset default cookie
				setcookie (session_name(), "", time()-3600); // set any default cookie to expire in a prior time
				session_destroy();  // kill the session
			}
		}
	}
}



// Client class inherits User
class Client extends User
{
	// array for holding objects
	protected $images;

	// Constructor for Client
	function __construct($usrID, $stat)
	{
		$this->user = $usrID;
		$this->userType = $stat;

		// get the image folder location & image list
		$this->imageLocation    =       $this->setupLocation();
		$this->images           =       $this->setupImageList();
	}


	// setupImageList()
	// fetch the images for the client
	protected function setupImageList()
	{
		$mysql = new Mysql();
		$result = $mysql->getImageList($this->user);  
		$files = array();
		// $this->images = array();

		foreach ($result as $key => $value)
		{
				$tempImage = new Image($this->user, $key, $value);
				array_push($files, $tempImage);
				// array_push($this->images, $tempImage);
		}
		return $files;
	}

	// get the image out of the array
	public function getImageNameFromArray($i)
	{
		return $this->images[$i];
	}

	// get the image array
	public function getImageArray()
	{
		return $this->images;
	}

	// return the size of the image array
	public function getSizeOfImageArray()
	{
		return sizeof($this->images);
	}
}



// Admin class inherits User
class Admin extends User
{
	private $clients; // an Array of Client list
	private $currentClient;

	// Constructor for Client
	function __construct($usrID, $stat)
	{
		$this->user = $usrID;
		$this->userType = $stat;

		// get the image folder location & image list
		$this->imageLocation    =       $this->setupLocation();
		$this->clients          =       $this->setupClientList();
	}

	// setupClientList()
	// setup a list of clients
	protected function setupClientList()
	{
		$type = 'CLIENT';
		$mysql = new Mysql();
		$result = $mysql->getClientList($type); 
		$clientList = array();
	
		foreach ($result as $value)
		{
			$tempClient = new Client($value, $type);
			array_push($clientList, $tempClient);
		}
		return $clientList;
	}

	// return the client array
	public function getClientList()
	{
		return $this->clients;
	}

	// return a client from the clients array
	public function getClientFromList()
	{
		return $this->clients[0];
	}

	// get the current selected client
	public function getCurrentClient()
	{
		return $this->currentClient;
	}

	// set the current client
	public function setCurrentClient($aClient)
	{
	 	$this->currentClient = $aClient;
	}
}