<?php
namespace model;

use model\Core as Core;
use modelTrait\GenerateDataFromResults;
use modelTrait\Pagination;

class UserCommon extends Core
{
    use GenerateDataFromResults; //formatted data
    use Pagination; //Pagination provider
    
    public function __construct() {
        
        parent::__construct();
    }
    
    function mySubjects()
    {
        $userId = $_SESSION['userId'];
        $select = mysql_query("SELECT * FROM subject_enrollees WHERE userId = $userId AND status = 'approved' ")  or exit(mysql_error());

        $data = $this->formatDataFromResult($select);
        
        return $data;
    }
    
    function mySubjectsModules($subjectId)
    {
        $data = null;
        
        $select = mysql_query("SELECT courseId, subjectName, subjectAdviser, subjectAdviserName,
            module.id as moduleId, moduleName
            FROM subject
            LEFT JOIN module
            ON subject.id = module.subjectId WHERE subject.id = '$subjectId'") or exit(mysql_error());
        
        $data = $this->formatDataFromResult($select);
        
        return $data;
    }
    
    public function mySubjectsModulesChapter($moduleId)
    {
        $data = null;
        
        $select = mysql_query("SELECT module.id as moduleId, moduleName,
            chapter.id as chapterId, chapterName, chapterDesc
            FROM module
            LEFT JOIN chapter
            ON module.id = chapter.moduleId WHERE module.id = '$moduleId' AND chapter.status = 'active'") or exit(mysql_error());
        
        $data = $this->formatDataFromResult($select);
        
        return $data;
    }
    
    public function mySubjectModuleChapterArticle($chapterId)
    {        
        $select = mysql_query("SELECT * FROM article WHERE chapterId = '$chapterId' AND status = 'active' ")  or exit(mysql_error());

        $data = $this->formatDataFromResult($select);
        
        return $data;
    }

    public function availableSubjects()
    {

        $userId = $_SESSION['userId'];

        $select = mysql_query("SELECT *
                FROM   subject
                WHERE  NOT EXISTS
                (SELECT *
                FROM   subject_enrollees
                WHERE  subject_enrollees.subjectId = subject.id AND subject_enrollees.userId = $userId)") or exit(mysql_error());

        $data = $this->formatDataFromResult($select);
        
        return $data;
    }

    public function subjectPendingRequest()
    {
        $data = null;
        $userId = $_SESSION['userId'];
        $select = mysql_query("SELECT * FROM subject_enrollees WHERE userId = $userId AND status != 'approved'") or exit(mysql_error());

        $data = $this->formatDataFromResult($select);

        return $data;
    }

    public function enrollSubject()
    {
        if(isset($_GET['enrollSubject'])) {
            $userId = $_SESSION['userId'];
            $subjectId = $_GET['enrollSubject'];

            //Get Subject Details
            $selectSubjectDetails = mysql_query("SELECT * FROM subject WHERE id = $subjectId") or exit(mysql_error());
            $subjectDetails = $this->formatDataFromResult($selectSubjectDetails)['data'][0];

            $parendDetailsArray = array('subjectName' => $subjectDetails['subjectName'],
                'subjectCode' => $subjectDetails['subjectCode'],
                'subjectGrade' => $subjectDetails['subjectGrade'],
                'subjectModule' => $subjectDetails['subjectModule'],
                'subjectDesc' => $subjectDetails['subjectDesc'],
                'subjectModule' => $subjectDetails['subjectModule'],
                'userName' => $_SESSION['lastName'].', '.$_SESSION['firstName'],
                'userGender' => $_SESSION['gender'],
                'userYearLevel' => $_SESSION['yearLevel'],
                'userEmail' => $_SESSION['email']);
            $parendDetailsObject = json_encode($parendDetailsArray);

            //Check if exist in db
            $check = mysql_query("SELECT * FROM subject_enrollees WHERE subjectId = '$subjectId' AND userId = '$userId'") or exit(mysql_error());

            //Save if not in db
            if (mysql_num_rows($check) < 1) {
                $insert = mysql_query("INSERT INTO subject_enrollees (userId, subjectId, details) VALUES ('$userId', '$subjectId' , '$parendDetailsObject')") or exit(mysql_error());                
            }       

        }
    }

}

$sideBar = new UserCommon();