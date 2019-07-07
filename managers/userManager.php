<?php
    /*
        The userManager.php is called when a user wants to log into the application
        I will handle the starting of a session here and create a client object which will
        handle all client work and properties
        notes & issues 
        need to pass serialised objects across pages, php will automatically parse objects in a serialised format that  will need to unpack on other pages
        however as sessions are more secure than cookies, they can still be hijacked, so I will encrypt them using base 64 encoding; they will need to be
        on encrypted on other pages during the session.
    */

    require_once '../classes/client.php';
    session_start();
    echo '<body style="background-color:SlateGrey">'; 
    echo '<div style ="font: 400 18px/1.8 Lato, sans-serif; color:AntiqueWhite">';
    echo "<hr/> <h1>Connecting to server</h1> <hr/>";
    $aClient = unserialize((base64_decode($_SESSION['clientSession'])));
    if(isset($_POST['loggedout'])) // if the user is trying to log out
    {
        if($aClient)
        {
            $aClient->userLogOut();
            unset($aClient);
        }
        header("location: https://tm470gap/index.html");
    }
    else
    {
        $aClient = new Client(); // create a new client object
   
        echo "<p> validate user </p>";
        // check username and password fields on the login have data
        if($_POST && !empty($_POST['username']) && !empty($_POST['pwd']))
        {
    
            $response = $aClient->validateUser($_POST['username'], $_POST['pwd']);
            if($response)
            {
                $srlClient = base64_encode(serialize($aClient));   //serialize the object
                $_SESSION['clientSession'] = $srlClient;    // pass the  serialised object into the session
                $_SESSION['imageNum'] = 0;
                if($aClient->getAccountType() == 1) // if admin goto admin menu
                {
                    header("location: https://tm470gap/menus/adminMenu.php"); 
                    return;    
                }
                header("location: https://tm470gap/menus/clientMenu.php"); // move to client menu
            }
            else 
            {
                unset($aClient);
                echo "<p> User login Failed</p>";
                header( "refresh:1;url=https://tm470gap/index.html" );
            }
        }    
    }