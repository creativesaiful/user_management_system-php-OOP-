<?php

class Database
{   
    const USERNAME = 'mizhazulhasan@gmail.com';
    const PASSWORD = '01917926548';

    
    private $dns = 'mysql:host=localhost;dbname=php_user_management';
    private $username = 'root';
    private $password = '';

    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dns, $this->username, $this->password);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $this->conn;
    }

    //input data check

    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Error Showing Message

    public function showMessage($type, $message)
    {
    return '<div class="alert alert-'.$type.' alert-dismissible"> <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong class="text-center">'.$message.' </strong>
    </div>';
    }
    

}
