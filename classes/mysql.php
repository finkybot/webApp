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

        // behavior: verify if the username and password is correct and authenticate
        // or inform user username/password is wrong
        function verifyUnamePwd($usrId, $pwd)
        {
            $result = false; // set return var to false (default)
            $query = "SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1"; // SQL query
            
            // attempt to prepare query 
            if($stmt = $this->conn->prepare($query))
            {
                // add paremeters and execute query
                $stmt->bind_param('ss',$usrId, $pwd);
                $stmt->execute();

                if($stmt->fetch())
                {
                    $stmt->close();
                    $result = true; // (user found) set returning var to true
                }


            }
            else 
            {
                echo "<p>username or password not recognised </p>";
            }

            $this->conn->close(); // close database connection
            return $result; // return $result
        }
    }


