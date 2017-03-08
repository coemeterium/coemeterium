<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\Helpers;

class Grave extends Core
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
        
        $data = $this->formatDataFromResult($select);
        
        return $data; 
    }

    public function getGraves()
    {
        $data = null;
        $select = mysql_query("SELECT * FROM grave WHERE status = 'vacant'") or exit(mysql_error());
        
        $data = $this->formatDataFromMultipleResult($select);
        
        return $data;
    }
    
    public function findTomb($searchTerm)
    {
        $srchTrm = explode(', ' , $searchTerm);
        
        $data = null;
        $lastName = $srchTrm[0];
        $firstName = (isset($srchTrm[1]) ? $srchTrm[1] : null);
        
        if ($lastName != null && $firstName != null) {            
            $select = mysql_query("SELECT * FROM d_person WHERE lastName = '$lastName' AND firstName = '$firstName'") or exit(mysql_error());
        } else {
            $select = mysql_query("SELECT * FROM d_person WHERE lastName = '$lastName'") or exit(mysql_error());            
        }
        
        $data = $this->formatDataFromMultipleResult($select);
        
        return $data;
    }
    
    public function searchGrave()
    {
        $code = 'test';
        $query = "SELECT * FROM d_people WHERE code = '$code'" or exit(mysql_error());
    }
}

$grave = new Grave();