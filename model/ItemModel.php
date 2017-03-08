<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;
use modelTrait\Helpers;

class Item extends Core
{	
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    use Helpers;

    public function __construct() {

        parent::__construct();
    }

    public function addItemAction()
    {
    	$isSave = false;

        //Check request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            
            $code = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
            $graveCode = $_POST['grave'];
            $graveLevel = $_POST['grave_level'];
            $lastName = $_POST['lastName'];
            $firstName = $_POST['firstName'];
            $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $placeOfBirth = isset($_POST['placeOfBirth']) ? $_POST['placeOfBirth'] : '';
            $gender = $_POST['gender'];
            $causedOfDeath = $_POST['causedOfDeath'];
            
            $bDate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;            
            $birthdate = null;			
			
			if ($bDate !== null) {
				$birthdate = $bDate['year'].'-'.$bDate['month'].'-'.$bDate['day'];			
			} else {
				$birthdate = null;			
			}
            
            $dOfDeath = isset($_POST['dateOfDeath']) ? $_POST['dateOfDeath'] : null;
			$dateOfDeath  = null;
			if ($dOfDeath) {
				$dateOfDeath = $dOfDeath['year'].'-'.$dOfDeath['month'].'-'.$dOfDeath['day'];
			} else {
				$dateOfDeath = null;
			}
            
            
            $dateExpiration = $_POST['dateExpiration'];
            
            
            
            
            $type_mnth_or_yr = $_POST['type_mnth_or_yr'];
            $type_rent_or_tit = $_POST['type_rent_or_tit'];
            $remarks = $_POST['remarks'];
            
            $query = "INSERT INTO d_person (code, lastName, firstName, middleName, gender, graveCode, level, address, dateOfBirth, dateOfDeath, placeOfBirth, causedOfDeath, type_mnth_or_yr, type_rent_or_tit, remarks, graveExpirationDate)"
                    . "VALUES('$code' ,'$lastName', '$firstName', '$middleName', '$gender', '$graveCode', '$graveLevel' ,'$address', '$birthdate', '$dateOfDeath', '$placeOfBirth', '$causedOfDeath', '$type_mnth_or_yr', '$type_rent_or_tit', '$remarks', '$dateExpiration')";
            $insD = mysql_query($query) or exit(mysql_error());
            
            if ($insD) {
                
                $profileId = mysql_insert_id();
                
                $graveDetails = $this->graveParser($graveCode);
                $graveNo = $graveDetails['graveNo'];
                $graveType = $graveDetails['type'];
                
                //check if grave exists in db                
                $selectGrave = mysql_query("SELECT * FROM grave WHERE code = '$graveCode' AND level = '$graveLevel' ") or exit(mysql_error());
                
                if (mysql_num_rows($selectGrave) < 1) {
                    
                    $insGraveQuery = "INSERT INTO grave (code, level, type, dPersonId, status, expirationDate)"
                        . "VALUES('$graveCode', '$graveLevel', '$graveType' ,'$profileId', 'occupied', '$dateExpiration')";
                    
                    $insG = mysql_query($insGraveQuery) or exit(mysql_error());
                    
                } else {
                    
                    mysql_query("UPDATE grave SET dPersonId = '$profileId', status = 'occupied' , expirationDate = '$dateExpiration' WHERE code = '$graveCode' AND level = '$graveLevel'") or exit(mysql_error());                                        
                }
                
                
                
                //Add Image Attachement
                $attachementsCounter = $_POST['attachmentCounter'];
                $uploadDir = '../bucket/grave/';

                for ($i = 1; $i <= $attachementsCounter; $i++) {
                    
                    if (isset($_FILES["attachment_".$i])) {
                        
                        $maximum_file_size = 5242880;/*20971520 kilobytes = 5 Megabytes*/
                        

                        $image_filename = $_FILES["attachment_".$i]['name'];
                        $image_tmpName = $_FILES["attachment_".$i]['tmp_name'];
                        $image_size = $_FILES["attachment_".$i]['size'];
                        $image_file_type = $_FILES["attachment_".$i]['type'];
                        $ext = substr(strrchr($image_filename, "."), 1);
                        $ext = strtolower($ext);
                        $randName = md5(rand() * time());
                        $imagePath = $uploadDir . $randName . '.' . $ext;
                        $image_filename = $randName . '.' . $ext;


                        $filename = $image_filename;
                        $newFilename = $randName . '.' . $ext;
                        $result = move_uploaded_file($image_tmpName, $imagePath);

                        $file = basename($_FILES["attachment_".$i]['name']);

                        $insertAttachments = mysql_query("INSERT INTO grave_images (graveCode, graveLevel, recordId, fileName, fileLocation) VALUES ('$graveCode', '$graveLevel', '$profileId', '$newFilename', '$imagePath')") or exit(mysql_error());

                    }
                }
                                
                //set success message
                $_SESSION['flash']['success'] = "Successfully saved.";
                $_SESSION['flash']['error'] = null;
            }
            
            $isSave = true;
        }
        
        return $isSave;
    
    }
    
    public function searchExpiredGrave() {
        
        $data = '';
        
        $today = date("Y-m-d");     
        
        
        $select = mysql_query("SELECT * FROM d_person WHERE graveExpirationDate = '$today'") or exit (mysql_error());        
        $data = $this->formatDataFromMultipleResult($select);
        
        if ($data['rows'] > 0) {
            
            foreach ($data['data'] AS $gxp) {

                $d_personId = $gxp['id'];
                $graveCode = $gxp['graveCode'];
                $graveCodeLevel = $gxp['level'];

                mysql_query("UPDATE d_person SET status = 'expired' WHERE id = '$d_personId'") or exit(mysql_error());
                mysql_query("UPDATE grave SET status = 'expired' WHERE code = '$graveCode' AND level = '$graveCodeLevel'") or exit(mysql_error());           
            }
        }
        
        return $data;
    }
    
    
    public function updateRecordAction($id)
    {
        $rs = [];
        $rs['isSave'] =  false;

        //Check request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $graveCode = $_POST['grave'];
            $graveLevel = $_POST['grave_level'];
            $lastName = $_POST['lastName'];
            $firstName = $_POST['firstName'];
            $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
            
            
            $bDate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;            
            $birthdate = isset($bDate['year']) ? $bDate['year'] : null
                    .'-'. isset($bDate['month']) ? $bDate['month'] : null
                    .'-'. isset($bDate['day']) ? $bDate['day'] : null;
            
            $dOfDeath = isset($_POST['dateOfDeath']) ? $_POST['dateOfDeath'] : null;            
            $dateOfDeath = isset($dOfDeath['year']) ? $dOfDeath['year'] : null.
                    '-'.isset($dOfDeath['month']) ? $dOfDeath['month'] : null.
                    '-'.isset($dOfDeath['day']) ? $dOfDeath['day'] : null;
            
            
            
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $placeOfBirth = isset($_POST['placeOfBirth']) ? $_POST['placeOfBirth'] : '';
            $gender = $_POST['gender'];
            $causedOfDeath = isset($_POST['causedOfDeath']) ? $_POST['causedOfDeath'] : null;
            $dateExpiration = $_POST['dateExpiration'];
            $type_mnth_or_yr = isset($_POST['type_mnth_or_yr']) ? $_POST['type_mnth_or_yr'] : null;
            $type_rent_or_tit = $_POST['type_rent_or_tit'];
            $remarks = $_POST['remarks'];
            
            
            $newGraveWithLevel = $graveCode . '-' . $graveLevel;
            
            $originalGrave = $_POST['originalGrave'];
            $originalGraveLevel = $_POST['originalGraveLevel'];
            $origGraveWithLevel = $originalGrave . '-' . $originalGraveLevel;

            
            $query = "UPDATE d_person SET lastName = '$lastName', firstName = '$firstName', middleName = '$middleName', gender = '$gender', graveCode = '$graveCode', dateOfBirth = '$birthdate', dateOfDeath = '$dateOfDeath', address = '$address', placeOfBirth = '$placeOfBirth', causedOfDeath = '$causedOfDeath', type_mnth_or_yr = '$type_mnth_or_yr', type_rent_or_tit = '$type_rent_or_tit', remarks = '$remarks', graveExpirationDate = '$dateExpiration' WHERE id = '$id'";
            $insD = mysql_query($query) or exit(mysql_error());
            
            if ($insD) {
                
                $profileId = $id;
                
                $graveDetails = $this->graveParser($graveCode);
                $graveNo = $graveDetails['graveNo'];
                $graveType = $graveDetails['type'];
                
                //check if grave exists in db                
                $selectGrave = mysql_query("SELECT * FROM grave WHERE code = '$graveCode' AND level = '$graveLevel' ") or exit(mysql_error());
                
                if (mysql_num_rows($selectGrave) < 1) {
                    
                    $insGraveQuery = "INSERT INTO grave (code, level, type, dPersonId, status, expirationDate)"
                        . "VALUES('$graveCode', '$graveLevel', '$graveType' ,'$profileId', 'occupied', '$dateExpiration')";
                    
                    $insG = mysql_query($insGraveQuery) or exit(mysql_error());
                    
                } else {
                    
                    mysql_query("UPDATE grave SET dPersonId = '$profileId', status = 'occupied' , expirationDate = '$dateExpiration' WHERE code = '$graveCode' AND level = '$graveLevel'") or exit(mysql_error());                                        
                }
                
                //update prev grave to vacant if grave was changed
                if ($newGraveWithLevel !== $origGraveWithLevel) {
                    mysql_query("UPDATE grave SET status = 'vacant' WHERE code = '$originalGrave' AND level = '$originalGraveLevel'") or exit(mysql_error());                     
                }
                
                
                
                
                
                
                //Add Image Attachement
                $attachementsCounter = $_POST['attachmentCounter'];
                $uploadDir = '../bucket/grave/';

                for ($i = 1; $i <= $attachementsCounter; $i++) {
                    
                    if (isset($_FILES["attachment_".$i])) {
                        
                        $maximum_file_size = 5242880;/*20971520 kilobytes = 5 Megabytes*/
                        

                        $image_filename = $_FILES["attachment_".$i]['name'];
                        $image_tmpName = $_FILES["attachment_".$i]['tmp_name'];
                        $image_size = $_FILES["attachment_".$i]['size'];
                        $image_file_type = $_FILES["attachment_".$i]['type'];
                        $ext = substr(strrchr($image_filename, "."), 1);
                        $ext = strtolower($ext);
                        $randName = md5(rand() * time());
                        $imagePath = $uploadDir . $randName . '.' . $ext;
                        $image_filename = $randName . '.' . $ext;


                        $filename = $image_filename;
                        $newFilename = $randName . '.' . $ext;
                        $result = move_uploaded_file($image_tmpName, $imagePath);

                        $file = basename($_FILES["attachment_".$i]['name']);

                        $insertAttachments = mysql_query("INSERT INTO grave_images (graveCode, graveLevel, recordId, fileName, fileLocation) VALUES ('$graveCode', '$graveLevel', '$profileId', '$newFilename', '$imagePath')") or exit(mysql_error());

                    }
                }              
                
                
                
                
                                                
                //set success message
                $_SESSION['flash']['success'] = "Successfully saved.";
                $_SESSION['flash']['error'] = null;
            }
            
            $rs['isSave'] =  true;
        }
        
        
        $selRec = mysql_query("SELECT * FROM d_person WHERE id = '$id'") or exit(mysql_error());
        $data = $this->formatDataFromResult($selRec);
        $rs['data'] =  $data['data'];
        $rs['type'] = $this->graveParser($data['data']['graveCode'])['type'];
                
        return $rs;
    
    }
}

$item = new Item();