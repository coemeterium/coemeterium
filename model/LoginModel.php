<?php
namespace model;

use model\Core as Core;
use model\UserModel as User;

class LoginModel extends Core
{       
    public function __construct()
    {     
        parent::__construct();
    }

    public function getCredentials()
    {   
    	$credentials = null;

        if (isset($_POST)) {

            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);
            $userType = $_POST['userType'] ? htmlentities($_POST['userType']) : 'admin';

            $credentials = array('username' => $username,
                    'password' => $password,
                    'userType' => $userType);
        }
        
        return $credentials;
    }

    public function loginAttempt()
    {        
        if(isset($_POST['loginAttempt'])) {               
            $loginAttempt = htmlentities($_POST['loginAttempt']);
        }else {
            $loginAttempt = 0;                
        }

        return $loginAttempt + 1;
    }

    public function loginCheck()
    {      
        $status = false;   
        $data = $this->getCredentials();

        $username   = $data['username'];
        $password   = md5($data['password']);
        $userType  =  $data['userType'];
        
        $query = "SELECT * FROM users WHERE username = '$username' "
                . "&& password = '$password' "
                . "&& status = 'active'"
                . "&& userType = '$userType' LIMIT 1";

        $select = mysql_query($query) or exit (mysql_error());

        //set sessions
        if ($select) {

            if (mysql_num_rows($select) > 0) {

                $data =  mysql_fetch_assoc($select);

                session_start(); //session start
                $_SESSION['login'] = TRUE;
                $_SESSION['userId']    = (int) $data['id'];
                $_SESSION['userType']  = $data['userType'];
                $_SESSION['username']  = $data['username'];
                $_SESSION['firstName'] = $data['firstName'];
                $_SESSION['middleName'] = $data['middleName'];
                $_SESSION['lastName']  = $data['lastName'];
                $_SESSION['birthdate'] = $data['birthdate'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['gender'] = $data['gender'];
                $_SESSION['profilePicture'] = $data['birthdate'];

                $status = true;
            }            
        }
        
        return $status;
    }


    public function redirect()
    {
        $userType = $_POST['userType'];

        if ($this->loginCheck() === true) {
            
            if ($userType === 'admin') {
                header("Location:../admin/?page=dashboard");                
            } else {
                header("Location:../?page=mySubjects&mySubjects=default");                
            }

        } else {
            
            if ($userType === 'admin') {
                header("Location:../admin/?page=login&error=1");               
            } else {
                header("Location:../?page=login&error=1");                
            }            
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $login = new loginModel();
    $login->redirect();
}