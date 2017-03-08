<?php
namespace model;

use model\Database as Database;

class Core
{
    public function __construct()
    {
        $dbConnect = new Database();	
            date_default_timezone_set('Asia/Manila');
	}
}