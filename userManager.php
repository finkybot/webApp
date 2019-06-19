<?php
    /*
        The userManager.php is called when a user wants to log into the application
        I will handle the starting of a session here and create a client object which will
        handle all client work and properties
        notes & issues 
        need to pass serialised objects across pages, php will automatically parse objects in a serialised format that i will need to unpack on other pages
        however as sessions are more secure than cookies, they can still be hijacked, so I will encrypt them using base 64 encoding; they will need to be
        on encrypted on other pages during the session.
    */

    require_once 'menus/classes/client.php';
    require_once 'menus/includes/functions.php';
    session_start();

    echo "<hr/> <h1>Connecting to server</h1> <hr/>";

    $aClient = new Client(); // create a new client object


    if(isset($_POST['loggedout'])) // if the user is trying to log out
    {
        $aClient->userLogOut();
        header("location: https://tm470gap/index.html");
    }

    if(isset($response)) 
    {
        echo "<h4>" . $response . "</h4>";
    }     

    
    echo "<p> validate user </p>";
    // check username and password fields on the login have data
    if($_POST && !empty($_POST['username']) && !empty($_POST['pwd']))
    {

        $response = $aClient->validateUser($_POST['username'], $_POST['pwd']);
        if($response)
        {
            $srlClient = base64_encode(serialize($aClient));   //serilize the object to create a string representation
            $_SESSION['clientSession'] = $srlClient;    // pass the encrypted serialised client object into the session
            $_SESSION['imageNum'] = 0;
            if(strcmp($aClient->getImageLoc(), 'admin') ===0)
            {
                header("location: https://tm470gap/menus/adminMenu.php"); // move now to the logged in page (this is just for testing)    
                return;    
            }
            header("location: https://tm470gap/menus/clientMenu.php"); // move now to the logged in page (this is just for testing)
        }
        else 
        {
            echo "<p> User login Failed</p>";
            header( "refresh:5;url=index.html" );
        }
    }    