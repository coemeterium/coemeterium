<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\Helpers;

class Settings extends Core
{	
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    use Helpers;

    public function __construct() {

        parent::__construct();
    }

    public function createGraveSlotAction()
    {
    	$isSaved = false;

        //Check request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $requestData = $_POST;

            $numberOfGraves = $_POST['numberOfGraves'];
            $blockNo = $_POST['block'];
            $type = strtolower($_POST['type']);
            $level = $_POST['level'];        


            for ($i = 1; $i <= $numberOfGraves; $i++) {

                $code = 'block'.$blockNo.'-'.'grave'.$i.'-'.$type;

                $query = "INSERT INTO grave (code, level, type) VALUES('$code', '$level', '$type')";
                $insert = mysql_query($query) or exit(mysql_error());            
            }
            
            $isSaved = true;
        }
        
        return $isSaved;
    
    }
}

$settings = new Settings();