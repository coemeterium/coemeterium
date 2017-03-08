<?php
namespace modelTrait;

trait GenerateDataFromResults 
{

    public function formatDataFromResult($result)
    {
        $data = [];
        $data['rows'] = 0;
        $data['data'] = [];

        if (mysql_num_rows($result) > 0) {
            
                $data['rows'] = mysql_num_rows($result);                
                
                while ($row = mysql_fetch_assoc($result)) {
                    $data['data'] = $row;
                }
        }
        
        return $data;
    }
    
    public function formatDataFromMultipleResult($result)
    {
        $data = [];
        $data['rows'] = 0;
        $data['data'] = [];

        if (mysql_num_rows($result) > 0) {
            
                $data['rows'] = mysql_num_rows($result);                
                
                while ($row = mysql_fetch_assoc($result)) {
                    $data['data'][$row['id']] = $row;
                }
        }
        
        return $data;
    }
}