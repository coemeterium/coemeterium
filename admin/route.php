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
            require_once '../model/activityModel.php';
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
    
        case 'records':
            require_once '../model/ItemModel.php'; 
            require_once '../model/DPersonModel.php';
            require_once 'pages/ListOfItems.php';            
        break;
    
        case 'add-item':
            require_once '../model/ItemModel.php'; 
            require_once '../model/GraveModel.php';
            require_once 'pages/AddItem.php';            
        break;
    
        case 'editrecord':
            require_once '../model/ItemModel.php'; 
            require_once '../model/GraveModel.php';
            require_once 'pages/editRecordPage.php';            
        break;
    
        case 'map':
            require_once '../model/ItemModel.php';
            require_once 'pages/MapPage.php';
        break;
    
        case 'add-grave-to-db':
            require_once '../model/Settings.php';
            require_once 'pages/addGraveSlotToDbPage.php';
        break;
    
        case 'newactivity':
            require_once '../model/activityModel.php';
            require_once 'pages/newActivityPage.php';
        break;
    
        case 'editactivity':
            require_once '../model/activityModel.php';
            require_once 'pages/editActivityPage.php';
        break;
    
        case 'logout':
            require_once '../model/LogoutModel.php';
        break;
    
    }
    
} else {
    
    if (isset($_SESSION['login'])) {
        header("Location:../". constant(BASE_URL) . '/admin/?page=dashboard');        
    } else {
        require_once '../model/LoginModel.php';
        require_once 'pages/LoginPage.php';      
    }
}