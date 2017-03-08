<?php
    //get userDetails
    $userDetails = $user->findById($_SESSION['userId']);
    $data = $userDetails['data'];
    $data['viewProfile'] = true;   
?>

<?php include_once 'template/header.php'; ?>
<?php include_once 'template/sidebar.php'; ?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
        <section class="panel">
            <header class="panel-heading">
                Profile
            </header>
            <div class="panel-body">

                <form class="form-horizontal col-lg-7 col-centered" name="user-form" method="POST" action="<?php echo CURRENT_PAGE ?>">
                    <div class="col-lg-7">
                        <?php include_once '../'.COMMON_FORM_DIR.'/profileForm.php' ?>
                    </div>
                </form>

            </div>
        </section>        
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>