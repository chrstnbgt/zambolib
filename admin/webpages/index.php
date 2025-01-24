<?php

    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin'){
        header('location: login.php');
    }