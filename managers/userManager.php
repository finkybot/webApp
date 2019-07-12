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
    require_once '../classes/mysql.php';
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
        echo "<p> validate user </p>";
        // check username and password fields on the login have data
        if($_POST && !empty($_POST['username']) && !empty($_POST['pwd']))
        {
            $mysql = new Mysql();
    
            $usrId = $_POST['username'];
            $pwd = $_POST['pwd'];

            $temp = $pwd . $usrId;
            $temp = md5($temp);
            $pwd = $temp . $pwd;
            $result = $mysql->verifyUser($usrId, sha1($pwd));
            
            if($result)
            {
                if(strcmp($result, 'CLIENT') == 0)
                {
                    $_SESSION['status'] = 'authorized';
                    // set the class variable
                    $aClient = new User($usrId, $result);

                    $srlClient = base64_encode(serialize($aClient));   //serialize the object
                    $_SESSION['clientSession'] = $srlClient;    // pass the  serialised object into the session
                    $_SESSION['imageNum'] = 0;

                    header("location: https://tm470gap/menus/clientMenu.php"); // move to client menu
                }

                if(strcmp($result, 'ADMIN') == 0)
                {
                    $_SESSION['status'] = 'authorized';
                    // set the class variable
                    $aClient = new User($usrId, $result);

                    $srlClient = base64_encode(serialize($aClient));   //serialize the object
                    $_SESSION['clientSession'] = $srlClient;    // pass the  serialised object into the session
                    $_SESSION['imageNum'] = 0;

                    header("location: https://tm470gap/menus/adminMenu.php"); 
                }
            }
            else 
            {
                unset($mysql);
                echo "<p> User login Failed</p>";
                header( "refresh:1;url=https://tm470gap/index.html" );
            }
        }    
    }