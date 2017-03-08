<?php
    $item->addItemAction();
    $graves = $grave->getGraves();
?>

<?php include_once 'template/header.php'; ?>
<?php include_once 'template/sidebar.php'; ?>


<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
    <div class="row">
        
        <div class="col-md-12">            
            <section class="panel custom-panel">
                
                <header class="panel-heading">
                    New Death Certificate Information
                </header>
                
                <div class="panel-body">
                    
                <?php
                    //alert box
                    echo $_SESSION['flash']['success'],
                         $_SESSION['flash']['error'];
                ?>

                <form class="form-horizontal col-lg-10 col-centered" name="add-form" method="POST" action="?page=add-item">
                    
                    <div class="col-lg-7">
                        
                        <div class="form-group">
                            <label class="f-label">* Grave:</label>
                            <label class="block clearfix">
                                <select name="grave" class='form-control' required="">
                                    <option value="">Select</option>
                                    <?php foreach ($graves['data'] as $grave) {                                     
                                        echo '<option>' . $grave['code'] . '</option>';
                                    } ?>
                                </select>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Last Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="lastName" class="form-control" required=""/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* First Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="firstName" class="form-control" required=""/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Middle Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="middleName" class="form-control"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Gender:</label>
                            <label class="block clearfix">
                                <select name="gender" class='form-control' required="">
                                    <option value="">Select</option> 
                                    <option value="Male">Male</option> 
                                    <option value="Female">Female</option> 
                                </select>                                
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Address:</label>
                            <label class="block clearfix">
                                <textarea name="address" class="form-control" required=""/> </textarea>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Place of Birth:</label>
                            <label class="block clearfix">
                                <textarea name="placeOfBirth" class="form-control" required=""/> </textarea>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Caused of Death:</label>
                            <label class="block clearfix">
                                <textarea name="causedOfDeath" class="form-control" required=""/> </textarea>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Expiration Date:</label>
                            <label class="block clearfix">
                                <input type="text" name="dateExpiration" class="form-control" required=""/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-success"> Save </button>
                            <a href="?page=items" class="btn btn-sm btn-success"> Cancel </a>
                        </div>
                        
                    </div>
                    
                </form>

                </div>
            </section>            
        </div>
        
        
    </div>
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>