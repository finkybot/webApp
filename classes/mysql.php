<?php
	// requirements
	$root = realpath($_SERVER["DOCUMENT_ROOT"]); 
	require_once $root. '/includes/constants.php';

// Mysql object
// handles connection the business client database
class Mysql
{
	private $conn; // attribute: holds a handle to an established database connection

	// Constructor for Mysql
	// attempts to establish a connection to the database server
	function __construct()
	{
		echo "<p>establish connection</p>";
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
		if($this->conn->connect_errno > 0) //check if conn
		{
			die('Unable to connect to database.. [' . $this->conn->connect_error . ']');
		}
	}

 	// verifyUser() CODE REVISION new wya of validating users
	function verifyUser($usrId, $pwd)
	{
		// note: remember I dont want to query image locations here so change this when I need to get both locations of the preview images and main images
		$result = false;
		$query = "SELECT client_type, password FROM users WHERE username = ? LIMIT 1"; // SQL query

		// attempt to prepare query 
		if($stmt = $this->conn->prepare($query)) // check the statement
		{
			// add paremeters and execute query
			$stmt->bind_param('s',$usrId);
			$stmt->execute();
			$stmt->bind_result($aType, $hash);
			if($stmt->fetch())
			{
				$stmt->close();
				if(password_verify($pwd, $hash))
				{
					$result = $aType; 
					$this->logAttempt($usrId,1); // log successful login attempt
				}
				else 
				{
					echo "<p>password not recognised</p>";
					$this->logAttempt($usrId,0); // log unsuccessful login attempt
				}
			}
			else 
			{
				echo "<p>user not recognised</p>";
			}
		}
		else 
		{
			echo "<p>Database query is not valid </p>";
		}
		$this->conn->close();
		return $result; 
	}

 // verifyUnamePwd() get the location of users images
	function getFileLocation($usr)
	{
		$result = false;
		$client = $usr->getUser();
		$result = false;
		$query = "SELECT image_location FROM users WHERE username = ? LIMIT 1"; 
		if($stmt = $this->conn->prepare($query))
		{
			// add paremeters and execute query
			$stmt->bind_param('s',$client);
			$stmt->execute();
			$stmt->bind_result($iLocation);

			if($stmt->fetch())
			{
				$stmt->close();
				$result = $iLocation; 
			}
		}
		$this->conn->close();
		return $result; 
	}

 // verifyUnamePwd() verify if the username and password is correct and authenticate
	function verifyUnamePwd($usrId, $pwd)
	{
		$result = array();
		$result[0] = false; 
		$result[1] = false;
		$query = "SELECT image_location, client_type FROM users WHERE username = ? AND password = ? LIMIT 1"; // SQL query
		if(strcmp($usrId, 'unknown') !==0)
		{
			if($stmt = $this->conn->prepare($query)) 
			{
				// add paremeters and execute query
				$stmt->bind_param('ss',$usrId, $pwd);
				$stmt->execute();
				$stmt->bind_result($iLocation, $aType);
				if($stmt->fetch())
				{
					$stmt->close();
					$result[0] = $iLocation; 
					$result[1] = $aType;
					$this->logAttempt($this->verifyUname($usrId),1); // log successful login attempt
				}
				else 
				{
					echo "<p>username or password not recognised </p>";
					$this->logAttempt($this->verifyUname($usrId),0); // log unsuccessful login attempt 
					return;
				}
			}
			else 
			{
				echo "<p>Database query is not valid </p>";
				return;
			}
		}
		else
		{
			echo "<p>invalid username....</p>";
			return;
		}
		$this->conn->close(); 
		return $result;
	}

	// getIMageList() gets the file names for each image for a given user
	function getImageList($usrId)
	{
		$query = "SELECT image_name, purchased FROM images WHERE username = ?"; 
		if($stmt = $this->conn->prepare($query))
		{
			// add paremeters and execute query
			$stmt->bind_param('s',$usrId);
			$stmt->execute();
			$stmt->bind_result($userImage, $status);
			$keys = array();
			$vals = array();
			$i = 0;					
			while($stmt->fetch())
			{
				$keys[$i] = $userImage;
				$vals[$i] = $status;
				$i++;                
			}
			$stmt->close();
		}
		$result = array_combine($keys, $vals);
		$this->conn->close();
		return $result; 
	}

	// getClientList() retrieves client list for admins
	function getClientList($type)
	{
		$query = "SELECT username FROM users WHERE client_type = ?"; 
		if($stmt = $this->conn->prepare($query)) 
		{
			// add paremeters and execute query
			$stmt->bind_param('s',$type);
			$stmt->execute();
			$stmt->bind_result($userName);
			$vals = array();
			$i = 0;
					
			while($stmt->fetch())
			{
				$vals[$i] = $userName;
				$i++;                
			}

			$stmt->close();
		}

		$this->conn->close();
		return $vals;
	}
			
	// private logAttempt() log users attempt to login on the database
	private function logAttempt($usrId, $state)
	{
		$query = "INSERT INTO `logger` (`logID`, `username`, `dateTime`, `log_status`) VALUES (NULL, ?, CURRENT_TIMESTAMP,?)"; // SQL query
		if($stmt = $this->conn->prepare($query)) // check the statement
		{
			// add paremeters and execute query
			$stmt->bind_param('ss',$usrId, $state);
			$stmt->execute();
			$stmt->close();
		}
		else 
		{
			echo "<script type='text/javascript'>alert('Log Failure');</script>";
			return;
		}
		return TRUE;
	}


 	// private verifyUname() verify if the username exists
	private function verifyUname($usrId)
	{  
		$query = "SELECT username FROM users WHERE username = ? LIMIT 1"; // SQL query
		if($stmt = $this->conn->prepare($query)) // check the statement
		{
			// add paremeters and execute query
			$stmt->bind_param('s',$usrId);
			$stmt->execute();
			$stmt->bind_result($var);
			if($stmt->fetch())
			{
				$stmt->close();
				return $var;
			}
		}
		return 'unknown';
	}
}