<?php 

require_once ('auth.php');

$user = new Auth();
if(isset($_POST['action']) && $_POST['action']=='register'){
  $name = $user->test_input($_POST['name']);
    $email = $user->test_input($_POST['email']);
    $password = $user->test_input($_POST['password']);

    $hpass = password_hash($password, PASSWORD_DEFAULT);

    if($user->user_exist($_POST['email'])){
        echo $user->showMessage('danger', 'User already exist');

    }else{
        if($user->register($name, $email, $hpass)){
            echo 'registered';
        }else{
            echo $user->showMessage('danger', 'Something went wrong');
        }
    }
};