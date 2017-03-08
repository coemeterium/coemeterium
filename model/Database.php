<?php
namespace model;

class Database {
    
    public function __construct() {
                
        $host = constant('HOST');
        $username = constant('HOST_USERNAME');
        $password = constant('HOST_PASSWORD');
        $database = constant('DATABASE_NAME');
        
        mysql_connect($host, $username, $password) or die(mysql_error());
        mysql_select_db($database) or die(mysql_error());
    }
}