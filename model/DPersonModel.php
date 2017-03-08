<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\Helpers;

class DPersonModel extends Core
{	
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    use Helpers;

    public function __construct() {

        parent::__construct();
    }
    
    public function getQuery($query){

        $data = null;
        $select = mysql_query($query) or exit(mysql_error());
        
        $data = $this->formatDataFromMultipleResult($select);
        
        return $data; 
    }

    public function findByName($name)
    {
        $brk = explode(' ', $name);
        
        $lastName = isset($brk[0]) ? $brk[0] : null;
        $firstName = isset($brk[1]) ? $brk[1] : null;
        
        if ($lastName != null && $firstName != null) {
            
            $statement = "d_person WHERE lastName LIKE '%$lastName%' AND firstName LIKE '%$firstName%' ORDER BY lastName";  
            
        } else if ($lastName != null && $firstName == null) {
            
            $statement = "d_person WHERE lastName LIKE '%$lastName%' ORDER BY lastName";   
            
        } else {
            
            $statement = "d_person WHERE lastName LIKE '%$lastName%' ORDER BY lastName";              
        }
        
        $paginationPage = (int) (!isset($_GET["pgntionPage"]) ? 1 : $_GET["pgntionPage"]);
        $limit = 10;
        $startpoint = ($paginationPage * $limit) - $limit;
        

        $result = mysql_query("SELECT * FROM {$statement} LIMIT {$startpoint} , {$limit}");
        
        $data = $this->formatDataFromMultipleResult($result);
        $data['pagination'] = $this->pagination($statement, $limit, $paginationPage);
        
        return $data; 
    }
    
    public function findAll($search = null)
    {
        $inlineAction = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inline_action'])) {
            
            $id = $_POST['id'];
            $graveCode = $_POST['graveCode'];
            $graveLevel = $_POST['graveLevel'];
            
            $updateRec = mysql_query("DELETE FROM d_person WHERE id = '$id'") or exit(mysql_error());
            $updateGrave = mysql_query("DELETE FROM grave WHERE code = '$graveCode' AND level = '$graveLevel'") or exit(mysql_error());
            
            $inlineAction = 'deleted';
            
        }
        
        $statement = '';
        $status = 'active';

        if ($search != null) {

            $brk = explode(' ', $search);

            $lastName = isset($brk[0]) ? $brk[0] : null;
            $firstName = isset($brk[1]) ? $brk[1] : null;

            if ($lastName != null && $firstName != null) {

                $statement = "d_person WHERE lastName LIKE '%$lastName%' AND firstName LIKE '%$firstName%' ORDER BY id DESC";  

            } else if ($lastName != null && $firstName == null) {

                $statement = "d_person WHERE lastName LIKE '%$lastName%' ORDER BY id DESC";   

            } else {

                $statement = "d_person WHERE lastName LIKE '%$lastName%' ORDER BY id DESC";              
            }          
        } else {
            $statement = "d_person ORDER BY id DESC";             
        }


        $paginationPage = (int) (!isset($_GET["pgntionPage"]) ? 1 : $_GET["pgntionPage"]);
        $limit = 10;
        $startpoint = ($paginationPage * $limit) - $limit;


        $result = mysql_query("SELECT * FROM {$statement} LIMIT {$startpoint} , {$limit}");

        $data = $this->formatDataFromMultipleResult($result);
        $data['pagination'] = $this->pagination($statement, $limit, $paginationPage);
        $data['inlineAction'] = $inlineAction;

        return $data; 
    }
    
    public function findById($id)
    {
        
        $data = [];
        
        $select = mysql_query("SELECT * FROM d_person WHERE id = '$id'") or exit(mysql_error());
        
        $data['data'] = $this->formatDataFromResult($select);
        $data['type'] = $this->graveParser($data['data']['data']['graveCode'])['type'];
        
        return $data;
    }
    
    public function findImagesByRecordId($recordId)
    {
        
        $data = null;
        
        $select = mysql_query("SELECT * FROM grave_images WHERE recordId = '$recordId'") or exit(mysql_error());
        
        $data = $this->formatDataFromMultipleResult($select);
        
        return $data;
    }
}

$dPersonModel = new DPersonModel();