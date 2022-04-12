<?php 

require_once ('auth.php');

/*================
Registration system Handle 
================*/

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


/*================
Login system Handle 
================*/

if(isset($_POST['action']) && $_POST['action']=='login'){
    $email = $user->test_input($_POST['email']);
    $pass = $user->test_input($_POST['password']);

    
    $data = $user->login($_POST['email']);

    if($user->login($_POST['email'])){
       if(password_verify($pass, $data['password'])){

       
           
        if(!empty($_POST['rem'])){
            setcookie('email', $email, time()+(30*24*60*60), '/' );
             setcookie('password', $pass,  time()+(30*24*60*60), '/' );
        }else{
             setcookie('email', '', 1, '/' );
              setcookie('password', '',1, '/' );
        }

        
           echo 'loggedin';

           $_SESSION['user'] = $email;
           
       }else{
           echo $user->showMessage('danger', 'Wrong password');
       }
        
    }else{
        echo $user->showMessage('danger', 'User not found');
    }

    
}

