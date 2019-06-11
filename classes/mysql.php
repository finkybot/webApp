<?php

    // requirements
    require_once 'includes/constants.php';

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
            $result = false; // set return var to false (default)
         // $query = "SELECT loc FROM users WHERE username = ? AND password = ? LIMIT 1"; // SQL query: when creating the preview image builder I will need this
            $query = "SELECT preview_location FROM users WHERE username = ? AND password = ? LIMIT 1"; // SQL query
            
            // attempt to prepare query 
            if($stmt = $this->conn->prepare($query)) // check the statement
            {
                // add paremeters and execute query
                $stmt->bind_param('ss',$usrId, $pwd);
                $stmt->execute();

                $stmt->bind_result($location);

                if($stmt->fetch())
                {
                    $stmt->close();
                    $result = $location; // (user found) set returning var to the location
                    //printf("%s", $name);
                }
            }
            else 
            {
                echo "<p>username or password not recognised </p>";
                return;
            }

            $this->conn->close(); // close database connection
            return $result; // return $result;
        }

        // behavior: get the file names for each image per
        // or inform user username/password is wrong
        function getImageLists($usrId, $type)
        {
            $results = []; // create an array for the results
            if($type == true)
            {
                $query = "SELECT image_name FROM images WHERE username = ?"; // SQL query selects the main images
            }
            else
            {
                $query = "SELECT preview_image_name FROM images WHERE username = ?"; // SQL query to select the name of any preview image
            }
            // attempt to prepare query 
            if($stmt = $this->conn->prepare($query)) // check the statement
            {
                // add paremeters and execute query
                $stmt->bind_param('s',$usrId);
                $stmt->execute();

                $stmt->bind_result($userImages);

                $i = 0;

                while($stmt->fetch())
                {
                    $i++;
                    $results[$i] = $userImages;
                }

                $stmt->close();
            }

            $this->conn->close(); // close database connection
            return $results; // return $result;
        }

    }


