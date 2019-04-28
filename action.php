<?php
    /*
        The action.php is called when a user wants to log into the application
        I will handle the starting of a session here and create a client object which will
        handle all client work and properties
        notes & issues 
        need to pass serialised objects across pages, php will automatically parse objects in a serialised format that i will need to unpack on other pages
        however as sessions are more secure than cookies, they can still be hijacked, so I will encrypt them using base 64 encoding; they will need to be
        on encrypted on other pages during the session.
    */
    session_start();
    require_once 'classes/clients.php';
    echo "<hr/> <h1>Connecting to server</h1> <hr/>";


    $account = new Client(); // create a new client object


    if(isset($_POST['loggedout'])) // if the user is trying to log out
    {
        $account->userLogOut();
        header("location: index.html");
    }

    if(isset($response)) 
    {
        echo "<h4>" . $response . "</h4>";
    }     

    
    echo "<p> validate user </p>";
    // check username and password fields on the login have data
    if($_POST && !empty($_POST['username']) && !empty($_POST['pwd']))
    {

        $response = $account->validateUser($_POST['username'], $_POST['pwd']);
        if($response)
        {
            $srlClient = base64_encode(serialize($account));   //serilize the object to create a string representation
            $_SESSION['clientSession'] = $srlClient;    // pass the encrypted serialised client object into the session
            $_SESSION['imageNum'] = 0;
            header("location: lnpage.php"); // move now to the logged in page (this is just for testing)
        }
        else 
        {
            echo "<p> User login Failed</p>";
        }
    }    