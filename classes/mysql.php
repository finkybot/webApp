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
        // or inform the user if it has failed
        function __construct()
        {
            echo "<p>establish connection</p>";
            $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
            if($this->conn->connect_errno > 0) //check if conn
            {
                die('Unable to connect to database.. [' . $this->conn->connect_error . ']');
            }
        }

        /* verifyUnamePwd($userId, $pwd) verify if the username and password is correct and authenticate
         * or inform user username/password is wrong
         * $userId          username of the client
         * $pwd             password of the client
         */ 
        function verifyUnamePwd($usrId, $pwd)
        {
            // note: remember I dont want to query image locations here so change this when I need to get both locations of the preview images and main images
            $result = array();
            $result[0] = false; // set return var to false (default)
            $result[1] = false;
         // $query = "SELECT loc FROM users WHERE username = ? AND password = ? LIMIT 1"; // SQL query: when creating the preview image builder I will need this
            $query = "SELECT image_location, client_type FROM users WHERE username = ? AND password = ? LIMIT 1"; // SQL query
 
            if(strcmp($usrId, 'unknown') !==0)
            {
                // attempt to prepare query 
                if($stmt = $this->conn->prepare($query)) // check the statement
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
                        $this->logAttempt($this->verifyUname($usrId),0); // log unsuccessful  attempt to login for the user
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
                $this->logAttempt('unknown',0); // log unsuccessful attempt for unknown username
                return;
            }

            $this->conn->close(); // close database connection
            return $result; // return $result;
        }

        // behaviour: get the file names for each image per
        // or inform user username/password is wrong
        function getImageList($usrId)
        {
            $query = "SELECT image_name, purchased FROM images WHERE username = ?"; // SQL query selects the main images
            // attempt to prepare query 
            if($stmt = $this->conn->prepare($query)) // check the statement
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
            $this->conn->close(); // close database connection
            return $result; // return $result;
        }


        /* private logAttempt($userId,) log users attempt to login on the database
         * $userId          username of the client
         * $state           success state of the login attempt
         */ 
        private function logAttempt($usrId, $state)
        {

            // note we are using the back quote `
            $query = "INSERT INTO `logger` (`logID`, `username`, `dateTime`, `log_status`) VALUES (NULL, ?, CURRENT_TIMESTAMP,?)"; // SQL query

            // attempt to prepare query 
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

            return TRUE; // return $result;
        }


        /* private verifyUname($userId) verify if the username exists
         * or set it to unknown (used for logging)
         * $userId username of the client
         */ 
        private function verifyUname($usrId)
        {  
            $query = "SELECT username FROM users WHERE username = ? LIMIT 1"; // SQL query

            // attempt to prepare query 
            if($stmt = $this->conn->prepare($query)) // check the statement
            {
                // add paremeters and execute query
                $stmt->bind_param('s',$usrId);
                $stmt->execute();

                $stmt->bind_result($var);

                if($stmt->fetch())
                {
                    $stmt->close();
                    return $var; // return the found user
                }
            }
            return 'unknown'; // default return unknown user
        }
    }


