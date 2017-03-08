<?php
    //on form submit
    $user->changePassword($_SESSION['userId']);

    //get userDetails
    $userDetails = $user->findById($_SESSION['userId']);
    $data = $userDetails['data'];
    $data['changePassword'] = true;   
?>

<?php include_once 'template/header.php'; ?>
<?php include_once 'template/sidebar.php'; ?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
        <section class="panel">            
            <header class="panel-heading">
                Change Password
            </header>
            
            <div class="panel-body">
                
                <?php
                    //alert box
                    echo $_SESSION['flash']['success'],
                         $_SESSION['flash']['error'];
                ?>
                
                <form class="form-horizontal col-lg-7 col-centered" name="user-form" id="form-change-password" method="POST" action="<?php echo CURRENT_PAGE ?>">
                    <div class="col-lg-7">
                        
                        <?php include_once '../'.COMMON_FORM_DIR.'/accountForm.php' ?>
                        
                        <?php if (!isset($_GET['view-profile'])) { ?>
                            <button class="btn btn-md btn-success btn-primary center-block" type="submit">SAVE</button>
                        <?php } ?>
                    </div>                   
                </form>
                
            </div>
        </section>
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>