<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\Helpers;

class UserModel extends Core
{	
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    use Helpers;

    public function __construct() {

        parent::__construct();
    }

    public function createAction()
    {
    	$data = null;

    //Check request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $requestData = $_POST;
        
        //Check username
        $username = $requestData['username'];
        $checkUsername = mysql_query("SELECT * FROM users WHERE username = '$username'") or exit (mysql_error());
        
        if (mysql_num_rows($checkUsername) > 0) {
            
            $_SESSION['flash']['success'] = null;
            $_SESSION['flash']['error'] = "Username is not available";
            return $data;
        }

    	// Save record from request
        $asColumn = null;
        $asValue = null;
        
        if ($requestData != null) {

            // Remove unnecessary fields
            if (isset($requestData['confirmPassword'])) {
            	unset($requestData['confirmPassword']); 
            }

            if (isset($requestData['loginAttempt'])) {
            	unset($requestData['loginAttempt']);
            }

            if (isset($requestData['redirectPage'])) {
            	unset($requestData['redirectPage']);
            }
            
            // Format to columns and values
            $i = 0;
            $length = count($requestData);
            
            foreach($requestData as $column=>$value) {
                
                $columnSeparator = ",";
                $valueSeparator = "',";
                
                if ($i == ($length - 1)) { 
                   $valueSeparator = "'"; 
                   $columnSeparator = "";
                }
                
                //set value
                $valueToSave = $value;
                
                if ($column === 'birthdate') {
                    $birthdate = $value['year'].'-'.$value['month'].'-'.$value['day'];
                    $valueToSave = $birthdate;                    
                }
                
                if ($column === 'password') {
                    $valueToSave = md5($value);                    
                }    
                
                $asColumn .= $column.$columnSeparator;   
                $asValue .= "'".$valueToSave.$valueSeparator;
                
                $i++;
            }            
        }

        $query = "INSERT INTO users "."(".$asColumn.") "." VALUES(".$asValue.")";
                
        $insert = mysql_query($query) or exit(mysql_error());

        if ($insert) {
            //set success message
            $_SESSION['flash']['success'] = "Successfully saved.";
            $_SESSION['flash']['error'] = null;

            return $data;
        }
    }
    
    $_SESSION['flash']['success'] = null;
    $_SESSION['flash']['error'] = null;

    return $data;
    }

    public function updateAction($id)
    {
        $data = $this->findById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $requestData = $_POST;

            // Save record from request
            $asColumn = null;
            $asValue = null;
            
            if ($requestData != null) {

                // Remove unnecessary fields
                if (isset($requestData['confirmPassword'])) {
                    unset($requestData['confirmPassword']); 
                }

                if (isset($requestData['loginAttempt'])) {
                    unset($requestData['loginAttempt']);
                }

                if (isset($requestData['redirectPage'])) {
                    unset($requestData['redirectPage']);
                }

                if (isset($requestData['password']) && ($_POST['password'] != null)) {
                  
                    $requestData['password'] = $requestData['password'];
                
                } else {
                    unset($requestData['password']);
                }
                
                // Format to columns and values
                $i = 0;
                $length = count($requestData);
                
                foreach($requestData as $column=>$value) {
                    
                    $columnSeparator = " ,";
                    
                    if ($i == ($length - 1)) { 
                       $columnSeparator = " ";
                    }
                    
                    //set value
                    $valueToSave = $value;
                    
                    if ($column === 'birthdate') {
                        $birthdate = $value['year'].'-'.$value['month'].'-'.$value['day'];
                        $valueToSave = $birthdate;                    
                    }
                    
                    if ($column === 'password') {
                        $valueToSave = md5($value);                    
                    }    
                    
                    $asColumn .= $column."="."'".$valueToSave."'".$columnSeparator;
                    
                    $i++;
                }            
            }

             $query = "UPDATE users SET ".$asColumn." WHERE id = '$id'";
                    
             $update = mysql_query($query) or exit(mysql_error());

            if ($update) {

                $data = $this->findById($id);
                //set success message
                $_SESSION['flash']['success'] = $this->alerBox('alert-success', 'Success', 'Successfully Updated.');
                $_SESSION['flash']['error'] = null;
                
                return $data;
            }
        }

        $_SESSION['flash']['success'] = null;
        $_SESSION['flash']['error'] = null;
        return $data;
    }
    

    public function deleteAction($id)
    {
        $softDelete = mysql_query("UPDATE users SET status = 'deleted' WHERE id = '$id'") or exit (mysql_error());
        
        if ($softDelete) {
            header("Location:../".PARENT_DIR.'?page=user');
        }        
    }
    
    public function retrieveAction($id)
    {
        $softDelete = mysql_query("UPDATE users SET status = 'active' WHERE id = '$id'") or exit (mysql_error());
        
        if ($softDelete) {
            header("Location:../".PARENT_DIR.'?page=user');
        }      
    }

    public function searchAction()
    {
        $data = null;

        if (isset($_GET['lastname'])) {

            $lastName = htmlentities($_GET['lastname']);

            $paginationPage = (int) (!isset($_GET["pgntionPage"]) ? 1 : $_GET["pgntionPage"]);
            $limit = 10;
            $startpoint = ($paginationPage * $limit) - $limit;
            
            $statement = "users WHERE lastName LIKE '%$lastName%' ORDER BY lastName";
            $result = mysql_query("SELECT * FROM {$statement} LIMIT {$startpoint} , {$limit}");
            
            $data = $this->formatDataFromResult($result);
            $data['pagination'] = $this->pagination($statement, $limit, $paginationPage);
        }

        return $data;
    }

    public function findById($id)
    {
       $select = mysql_query("SELECT * FROM users WHERE id = $id LIMIT 1") or exit (mysql_error());       
       //Format data from trait
       $formattedData = $this->formatDataFromResult($select);
       
       return $formattedData;
    }
    
    public function finsdfddAll()
    {

        $result = mysql_query("SELECT * FROM users");
        
        $data = $this->formatDataFromMultipleResult($result);
        
        return $data;
    }
    
    public function changePassword($id) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $oldPassword = $_POST['oldPassword'];
            $newPassword = md5($_POST['password']);
            
            $getUser = $this->findById($id);
                        
            //If Old Password did not match
            if($getUser['data']['password'] != md5($oldPassword)) {
                
                //set success message
                $_SESSION['flash']['success'] = null;
                $_SESSION['flash']['error'] = $this->alerBox('alert-danger', 'Error', 'Old Password did not match.');
                
                return false;                
            }           
            
            $update = mysql_query("UPDATE users SET password = '$newPassword'  WHERE id = $id") or exit (mysql_error());
            
            if($update) {
                //set success message                
                $_SESSION['flash']['success'] = $this->alerBox('alert-success', 'Success', 'Password change.'); 
                $_SESSION['flash']['error'] = null;
            }
        }
    }
    
    //Used by ajax
    public function checkUsername($username)
    {
        $select = mysql_query("SELECT * FROM users WHERE username = '$username'") or exit (mysql_error());
        
        if (mysql_num_rows($select) < 1) {
            echo json_encode('available');
        }  else {
            echo json_encode('notAvailable');
        }
    }
}

$user = new UserModel();