<?php
namespace model;

use model\Core as Core;

class Parser extends Core
{
    public function __construct() {
        
        parent::__construct();
    }
    
    public function graveName($graveCode = 'block-1-d1')
    {
        
        $xprt = explode('-', $graveCode);
        
        $block = isset($xprt[0]) ? $xprt[0] : '';
        $blockNum = isset($xprt[1]) ? $xprt[1] : 0;
        $grave = isset($xprt[2]) ? $xprt[2] : null;
        $graveNum = isset($xprt[3]) ? $xprt[3] : null;
        
        return $block . ' ' . $blockNum. ' ' . $grave . ' ' . $graveNum;        
    }

}

$parser = new Parser();