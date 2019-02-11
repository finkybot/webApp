<?php
    session_start();
    require_once 'classes/clients.php';
    echo "<hr/> <h1>Testing connection</h1> <hr/>";

    $member = new Client();

    if(isset($_GET['status']) && $_GET['status'] == 'loggedout')
    {
        $member->userLogOut();
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
        $response = $member->validateUser($_POST['username'], $_POST['pwd']);
        if($response)
        {
            header("location: lnpage.php");
        }
        else 
        {
            echo "<p> User login Failed</p>";
        }
    }
?>

        