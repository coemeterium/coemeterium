<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\commonOptions;
use modelTrait\Helpers;

class AjaxRequest extends Core
{
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    use commonOptions; //options
    use Helpers;
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function searchDPerson($id)
    {
        $select = mysql_query("SELECT * FROM d_person WHERE id = '$id'") or exit(mysql_error());
        
        $data = $this->formatDataFromResult($select);
        
        echo json_encode($data['data']);
        
        return json_encode($data['data']);        
    }
    
    public function checkAccessCode($code, $id)
    {
        $rs =  ['status' => 'error'];
        $select = mysql_query("SELECT * FROM d_person WHERE id = '$id'") or exit(mysql_error());
        
        $data = $this->formatDataFromResult($select);
        
        if (isset($data['data']['code']) && $data['data']['code'] == $code) {
            $rs = ['status' => 'success'];           
        }
        
        echo json_encode($rs);
        
        return json_encode($rs);        
    }
    
    public  function getAllGraveStatus() {
        
        $rs =  ['status' => 'error'];
        $select = mysql_query("SELECT * FROM grave") or exit(mysql_error());
        
        $rs = [];
        $rs['graves'] = [];
        $rs['expiredPrivateGraves'] = [];
        
        $queryResults = $this->formatDataFromMultipleResult($select);
        
        foreach ($queryResults['data'] as $key=>$result) {
            
            $id = $result['id'];
            $code = $result['code'];
            $type = $result['type'];
            
            
            $countAllInDb = mysql_query("SELECT * from grave WHERE code = '$code'") or exit(mysql_error());
            $countAllInDbCount = mysql_num_rows($countAllInDb);
            
            $selectAllByCode = mysql_query("SELECT * from grave WHERE code = '$code' AND status = 'occupied'") or exit(mysql_error());
            $count = mysql_num_rows($selectAllByCode);
            
            $countAllInDbVacant = mysql_query("SELECT * from grave WHERE code = '$code' AND status = 'expired'") or exit(mysql_error());
            $countAllInDbVacantCount = mysql_num_rows($countAllInDbVacant);
            
            
            
            $rs['graves'][$code] = [];
            $rs['graves'][$code]['code'] = $code;
            $rs['graves'][$code]['count'] = $count;
            $rs['graves'][$code]['type'] = $type ;
            
            if ($type == 'public' && $count >= 4) {
                
                $rs['graves'][$code]['status'] = 'red';
                
            } else if ($type == 'public' && $countAllInDbCount == 4 && $countAllInDbVacantCount >= 1) {
                
                $rs['graves'][$code]['status'] = 'red'; 
                
            } else if ($type == 'private' && $count >= 1) {
                
                $rs['graves'][$code]['status'] = 'red'; 
                
            }
            
            else {
                $rs['graves'][$code]['status'] = 'green';                 
            }
        }
        
        //select all expired private graves
        $selectExpGraves = mysql_query("SELECT id, code, status FROM grave WHERE type = 'private' AND status = 'expired'") or exit(mysql_error());
        $rs['expiredPrivateGraves'] = $this->formatDataFromMultipleResult($selectExpGraves)['data'];
        
        //select all expired public graves
        $selectExpPublicGraves = mysql_query("SELECT id, code, status FROM grave WHERE type = 'public' AND status = 'expired'") or exit(mysql_error());
        $rs['expiredPublicGraves'] = $this->formatDataFromMultipleResult($selectExpPublicGraves)['data'];
        
        
        echo json_encode($rs);
        
        return json_encode($rs);        
    }
    
    public function getAllGraveAvailableLevel($code) {
        
        $defaultGraveLevel = [1, 2, 3, 4];
        $levelInDb = [];
        $newAvailableLevel = [];
        
        $selectAll = mysql_query("SELECT * from grave WHERE code = '$code' AND (status = 'occupied' || status = 'expired') ") or exit(mysql_error());
        $results = $this->formatDataFromMultipleResult($selectAll);
        
        foreach ($results['data'] as $result) {
            
            $level = (int) $result['level'];
            $levelInDb[$level] = $level;
        }
        
        
        //create avaialble grave lavel
        foreach ($defaultGraveLevel as $availableLevel) {
            
            if (!(in_array($availableLevel, $levelInDb))) {
                $newAvailableLevel[$availableLevel] = '<option value="' . $availableLevel . '"> ' . $availableLevel . ' </option>';                
            }
                                    
        }
        
        echo json_encode($newAvailableLevel);
        
        return json_encode($newAvailableLevel);
        
    }
    
    public function getGraveDetails($code) {
        
        $parse = $this->graveParser($code);
        $data = [];
        $data['type'] = $parse['type'];
        $data['data'] = '';
        $data['noRecords'] = 1; 
        $data['showAddRecordBtn'] = 1; 

            
        $graveSql = "SELECT grave.id  as id, d_person.id as dPersonId, d_person.firstName, d_person.lastName, d_person.gender, d_person.dateOfBirth, d_person.dateOfDeath, d_person.causedOfDeath, d_person.graveExpirationDate,
            grave.level as graveLevel, grave.status, grave.level, grave.expirationDate, grave.type, grave.code
            FROM grave            
            LEFT JOIN d_person            
            ON grave.dPersonId = d_person.id
            WHERE grave.code = '$code' AND (grave.status = 'occupied' || grave.status = 'expired')  ORDER BY id DESC";

        $getDetails = mysql_query($graveSql) or exit(mysql_error());

        if (mysql_num_rows($getDetails) > 0) {

                $data['noRecords'] = 0;

                $data['rows'] = mysql_num_rows($getDetails);               

                while ($row = mysql_fetch_assoc($getDetails)) {
                    $data['data'][$row['id']] = $row;
                }
        } else {
            $data['noRecords'] = 1;            
        }
        
        //set if show Add New Record in FrontEnd
                
        //check if grave exists in db
        $sqlIfExist = mysql_query("SELECT * FROM grave WHERE code = '$code'") or exit (mysql_error());
        $sqlIfExistCount = mysql_num_rows($sqlIfExist);
        
        if ($sqlIfExistCount > 0) {
            
            $sqlOccp = mysql_query("SELECT * FROM grave WHERE code = '$code' AND status = 'occupied'") or exit (mysql_error());
            $sqlOccpCount = mysql_num_rows($sqlOccp);
            
            $sqlVacant = mysql_query("SELECT * FROM grave WHERE code = '$code' AND status = 'vacant'") or exit (mysql_error());
            $sqlVacantCount = mysql_num_rows($sqlVacant);
            
            if ($parse['type'] =='public' && $sqlIfExistCount == 4 && $sqlVacantCount < 1) {
                $data['showAddRecordBtn'] = 0;                
            } else if ($parse['type'] == 'private' && $sqlOccpCount >= 1) {
                $data['showAddRecordBtn'] = 0;                
            } else if ($parse['type'] =='private' && $sqlIfExistCount >= 1 && $sqlVacantCount < 1) {
                $data['showAddRecordBtn'] = 0;                 
            }            
            
        } else {
            $data['showAddRecordBtn'] = 1;            
        }                
        
        echo json_encode($data);
        
        return json_encode($data);
        
    }
    
    function getMoveToBoneChamber($graveId = 0) {
        
        $boneChamberGraveId = 'block1-grave1-bonechamber';
        $data =  [];
        
        $sqlSelectGrave = mysql_query("SELECT * FROM grave WHERE id = '$graveId'") or exit(mysql_error());
        $selectGraveD = $this->formatDataFromResult($sqlSelectGrave);
        
        $dPersonId = $selectGraveD['data']['dPersonId'];
        
        //update the dPerson grave
        mysql_query("UPDATE d_person SET graveCode = '$boneChamberGraveId',  level = '1', graveExpirationDate = '0000-00-00' WHERE id = '$dPersonId'") or exit(mysql_error());
        
        
        //delete the grave
        mysql_query("DELETE FROM grave WHERE id = '$graveId'") or exit(mysql_error());
        
        //insert bone chamber grave
        mysql_query("INSERT INTO grave (code, dPersonId, level, status, type, expirationDate) VALUES('$boneChamberGraveId', '$dPersonId', '1' , 'occupied', 'bonechamber' , '000-00-00')") or exit(mysql_error());
        
        
        $data['dPersonId'] = $dPersonId;

        
        echo json_encode($data);        
        return json_encode($data);              
        
    }
}

$ajaxRequest = new AjaxRequest();