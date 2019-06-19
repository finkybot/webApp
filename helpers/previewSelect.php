<?php
require_once 'classes/client.php';
    session_start();
    // ensure user is logged in
    $account = unserialize((base64_decode($_SESSION['clientSession'])));
    if(!$account)
    {
        header('location: index.html');
        exit;
    }
  
    if(isset($_POST['up']))
    {
        $_SESSION['imageNum']++;
        header("location: preview.php"); // move now to the logged in page (this is just for testing)
    }    

    if(isset($_POST['down']))
    {
        $_SESSION['imageNum']--;
        header("location: preview.php"); // move now to the logged in page (this is just for testing)

    }    