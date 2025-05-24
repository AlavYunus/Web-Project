<?php

    session_start();
    $_SESSION = array(); 
    session_destroy();//clear all sessions
    header("Location: login.php");

?>