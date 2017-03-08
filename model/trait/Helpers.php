<?php
namespace modelTrait;

trait Helpers {
    
    public function alerBox($class = null, $header = null, $desc = null)
    {
        $alert = '<div class="alert-box alert ' . $class . '">'.
                '<button data-dismiss="alert" class="close close-sm" type="button">'.
                    '<i class="fa fa-times"></i>'.
                '</button>'.
                '<strong>' . $header . '!</strong> ' . $desc .
            '</div>';
    
        return $alert;
    }
    
    public function graveParser($code) {
        
        $rs = [];
        $xpld = explode('-', $code);
        
        $rs = array(
            'block' => $xpld[0], 
            'graveNo' => $xpld[1], 
            'type' => $xpld[2]);
        
        return $rs;
    }
}