<?php
//Use for sidebar on which item is active
$sideBarActiveStatus = function($selfClass) {

    $isActive =  null;

    if (isset($_GET['page'])) {
        
        $explode = explode('-', htmlentities($_GET['page']));
       
        if ($explode[0] === $selfClass) {

            return 'active';
        }
    }
    
    return $isActive;
};

//Routes
if (isset($_GET['page'])) {

    $pageName = htmlentities($_GET['page']);
    
    $isAuthenticated = ['dashboard', 'edit-profile'];
    if (in_array($pageName, $isAuthenticated) && !isset($_SESSION['login'])) {
        header("Location:../". constant(BASE_URL) . '/admin');        
    }
    
    switch ($pageName) {
        
        case 'login':
            require_once '../model/LoginModel.php';
            require_once 'pages/LoginPage.php';
        break;
    
        case 'dashboard':
            require_once '../model/DashboardDefaultModel.php';
            require_once 'pages/Dashboard.php';
        break;
    
        case 'edit-profile':
            require_once '../model/UserModel.php';
            require_once 'pages/EditProfilePage.php';
        break;
    
        case 'view-profile':
            require_once '../model/UserModel.php';
            require_once 'pages/ViewProfilePage.php';
        break;
    
        case 'change-password':
            require_once '../model/UserModel.php';
            require_once 'pages/ChangePasswordPage.php';
        break;
    
        case 'map':
            require_once 'model/DPersonModel.php';
            require_once 'user/pages/mapPage.php';
        break;   
    
        case 'search':
            require_once 'model/DPersonModel.php';
            require_once 'user/pages/searchResultsPage.php';
        break;
		
        case 'contactus':
            require_once 'user/pages/contactusPage.php';
        break;
		
        case 'about':
            require_once 'user/pages/aboutPage.php';
        break;
    
        case 'ajax-search':
            require_once 'model/AjaxRequest.php';
            $ajaxRequest->searchDPerson($_GET['itemId']);
        break;
    
        case 'ajax-check-access-code':
            require_once 'model/AjaxRequest.php';
            $ajaxRequest->checkAccessCode($_GET['code'], $_GET['id']);
        break;
    
        case 'ajax-get-all-grave-status':
            require_once 'model/AjaxRequest.php';
            $ajaxRequest->getAllGraveStatus();
        break;
    
        case 'ajax-get-all-grave-available-level':
            require_once 'model/AjaxRequest.php';
            $ajaxRequest->getAllGraveAvailableLevel($_GET['code']);
        break;
    
        case 'ajax-get-grave-details':
            require_once 'model/AjaxRequest.php';
            $ajaxRequest->getGraveDetails($_GET['code']);
        break;
    
        case 'ajax-move-to-bone-chamber':
            require_once 'model/AjaxRequest.php';
            $ajaxRequest->getMoveToBoneChamber($_GET['graveId']);
        break;
    
        case 'logout':
            require_once '../model/LogoutModel.php';
        break;
    
    }
    
} else {
    
    if (isset($_SESSION['login'])) {
        header("Location:../". constant(BASE_URL) . '/admin/?page=dashboard');        
    } else {
        require_once 'model/activityModel.php';
        require_once 'user/pages/homePage.php';      
    }
}