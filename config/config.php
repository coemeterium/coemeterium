<?php
require_once __DIR__.'/../vendor/autoload.php';

/*Get parent page or parent Dir (e.g. /admin or /guest) */
$parentDir = function() {

	$dir = null;

	$explodeUrl = explode('/', $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

	if (count($explodeUrl) > 1) {
		$dir = $explodeUrl[1];
	}

	return 	$dir;
};

/*Get current page (e.g. admin/?page=dashboard) */
$currentPage = function() {

	$dir = null;

	$explodeUrl = explode('&', $_SERVER["QUERY_STRING"]);

	if (count($explodeUrl) > 1) {
		$dir = '?'.$explodeUrl[0];
	} else {
		$dir = '?'.$_SERVER["QUERY_STRING"];
	}

	return 	$dir;
};

define('BASE_URL', 'http://coemeterium');
define('COMMON_FORM_DIR', 'app/resources/forms');

define('PARENT_DIR', $parentDir(), true);
define('CURRENT_PAGE', BASE_URL . '/'. PARENT_DIR . '/' . $currentPage(), true); //e.g admin/?page=dashboard
define('CURRENT_PAGE_SELF', '?'.$currentPage(), true); //e.g ?page=dashboard
