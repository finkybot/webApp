<?php
    /*

    */
    session_start();
    require_once 'classes/clients.php';
  
    if(isset($_POST['up']))
    {
            $_SESSION['imageNum']++;
            header("location: lnpage.php"); // move now to the logged in page (this is just for testing)

    }    

    if(isset($_POST['down']))
    {
            $_SESSION['imageNum']--;
            header("location: lnpage.php"); // move now to the logged in page (this is just for testing)

    }    