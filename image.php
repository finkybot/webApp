<?php
    session_start();
    require_once 'classes/clients.php';
    require_once 'includes/functions.php';

    // ensure user is logged in
    $account = new Client();
    $account->confirmClient();

    // fetch a passed value to find current image 
    $cVal = $_GET['val'];
    if(is_numeric($cVal))
    {
        // read jpeg image into buffer for displaying, remember files being read from outside of root folder
        header('Content-Type: image/jpeg');
        readfile("/var/www/other/test/" . $_SESSION['file'][$cVal]);
    }
?>