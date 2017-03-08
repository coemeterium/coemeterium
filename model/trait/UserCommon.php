<?php
namespace modelTrait;

trait UserCommon {
    
    function mySubjects()
    {
        $select = mysql_query("SELECT * FROM subject WHERE status = 'active' ")  or exit(mysql_error());

        $data = $this->formatDataFromResult($select);
        
        return $data;
    }
}