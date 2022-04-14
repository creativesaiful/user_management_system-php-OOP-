<?php 

require_once ('auth.php');



//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

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
            session_start();
            $_SESSION['user'] = $email;
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

           session_start();
           $_SESSION['user'] = $email;

           
           
       }else{
           echo $user->showMessage('danger', 'Wrong password');
       }
        
    }else{
        echo $user->showMessage('danger', 'User not found');
    }

    
}

/*================
Forgot password Handle 
================*/

if(isset($_POST['action']) && $_POST['action']=='forgot'){
    $email = $user->test_input($_POST['email']);

   $user_check =  $user->current_user($email);

   if($user_check != NULL){
       $token = uniqid();
       $token = str_shuffle($token);
       
       $res = $user->token_store( $_POST['email'], $token);

       if($res == true){
           
        try{
            //Server settings
          //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $user::USERNAME;                     // SMTP username

            $mail->Password   = $user::PASSWORD;                               // SMTP password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($user::USERNAME , 'Admin');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reset Password';
            $mail->Body    = '<h2>Please click the the link to reset your password</h2>  <a href="http://localhost/php/reset.php?token='.$token.'">Reset Password</a></br> <p>Regards, </p> <p>Admin</p>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

           if( $mail->send()){
            echo $user->showMessage('success', 'Check your email');
           }else{
            echo $user->showMessage('danger', 'Something went wrong');
           }

            

            

        }
        catch(Exception $e){
            echo $user->showMessage('danger', 'Something went wrong');
        }



       }else{
              echo $user->showMessage('danger', 'Something went wrong');
       }

   }else{
         echo $user->showMessage('danger', 'User not found');
   }
}