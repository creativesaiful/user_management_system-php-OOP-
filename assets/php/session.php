<?php
require_once ('auth.php');

session_start();

$cuser = new Auth();

if(!isset($_SESSION['user'])){
    header('Location: index.php');
    die();
}

$cemail = $_SESSION['user'];

$data = $cuser->current_user($cemail);