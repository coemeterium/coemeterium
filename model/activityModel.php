<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\Helpers;

class ActivityModel extends Core
{	
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    use Helpers;

    public function __construct() {

        parent::__construct();
    }
    
    public function createActivity(){

        $isSave = false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $title = $_POST['title'];
            $description = $_POST['description'];
            $date = $_POST['date'];
            
            
            $query = "INSERT INTO activities (title, description, date)"
                    . "VALUES('$title' ,'$description', '$date')";
            $insD = mysql_query($query) or exit(mysql_error());
            
            $isSave = true;
        }
        
        return $isSave; 
    }
    
    public function findAll($status = 'all')
    {
        $inlineAction = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  (isset($_POST['inline_action']) && $_POST['inline_action'] =='delete')) {
            
            $id = $_POST['id'];            
            $updateRec = mysql_query("UPDATE activities SET status = 'deleted' WHERE id = '$id'") or exit();            
            $inlineAction = 'deleted';            
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  (isset($_POST['inline_action']) && $_POST['inline_action'] =='publish')) {
            
            $id = $_POST['id'];            
            $updateRec = mysql_query("UPDATE activities SET status = 'published' WHERE id = '$id'") or exit();            
            $inlineAction = 'published';            
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  (isset($_POST['inline_action']) && $_POST['inline_action'] =='unpublished')) {
            
            $id = $_POST['id'];            
            $updateRec = mysql_query("UPDATE activities SET status = 'unpublished' WHERE id = '$id'") or exit();            
            $inlineAction = 'unpublished';            
        }
        
        
        $statement = '';
        
        if ($status == 'published') {
            $statement = "activities WHERE status = 'published' ORDER BY date DESC";             
        } else {
            $statement = "activities ORDER BY date DESC";             
        }

        $paginationPage = (int) (!isset($_GET["pgntionPage"]) ? 1 : $_GET["pgntionPage"]);
        $limit = 20;
        $startpoint = ($paginationPage * $limit) - $limit;


        $result = mysql_query("SELECT * FROM {$statement} LIMIT {$startpoint} , {$limit}");

        $data = $this->formatDataFromMultipleResult($result);
        $data['pagination'] = $this->pagination($statement, $limit, $paginationPage);
        $data['inlineAction'] = $inlineAction;

        return $data; 
    }
    
    public function updateActivity($id)
    {
        
        $rs = [];
        $data = null;
        $rs['isUpdated'] = false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $title = $_POST['title'];
            $description = $_POST['description'];
            $date = $_POST['date'];

            
            $query = "UPDATE activities SET title = '$title', description = '$description', date = '$date' WHERE id = '$id'";
            $insD = mysql_query($query) or exit(mysql_error());
            
            $rs['isUpdated'] = true;            
        }
        
        $selRec = mysql_query("SELECT * FROM activities WHERE id = '$id'") or exit(mysql_error());
        $data = $this->formatDataFromResult($selRec);
        $rs['data'] =  $data['data'];
        
        return $rs;
    }
}

$activity = new ActivityModel();