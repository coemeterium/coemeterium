<?php
namespace modelTrait;

trait commonOptions {
    
    function getSubjectOptions()
    {
        $select = mysql_query("SELECT * FROM subject WHERE status = 'active' ")  or exit(mysql_error());

        $data = $this->formatDataFromResult($select);
        
        return $data;
    }
    
    function getModuleOptions()
    {
        $select = mysql_query("SELECT * FROM subject WHERE status = 'active' ")  or exit(mysql_error());

        $data = $this->formatDataFromResult($select);
        
        return $data;
    } 
    
    function getUserDetails($userId) {
        
        $select = mysql_query("SELECT * FROM users WHERE id = '$userId' ")  or exit(mysql_error());
        
        $data = $this->formatDataFromResult($select);
        
        return $data;                
    }
}