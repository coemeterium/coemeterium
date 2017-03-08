<?php 

$create = $settings->createGraveSlotAction();

if ($create) {
    //header("Location:../". constant(BASE_URL) . '/admin/?page=add-grave-to-db');      
}

include_once 'template/header.php';
include_once 'template/sidebar.php';
?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
    <div class="row">
        
        <div class="col-md-12">         
            <section class="panel custom-panel">
                <header class="panel-heading">
                    Create Grave to Database
                </header>
                <div class="panel-body">     

<form class="col-lg-12" method="POST" action="<?php echo BASE_URL.'/admin/?page=add-grave-to-db' ?>">
    <div class="form-group">
        <label class="f-label">* Block No.:</label>
        <label class="block clearfix">
            <input type="number" name="block" class="form-control" 
                placeholder="Block" required=""/>
        </label>
    </div>
    
    <div class="form-group">
        <label class="f-label">* Number of Graves:</label>
        <label class="block clearfix">
            <input type="input" name="numberOfGraves" class="form-control" 
                placeholder="Count Number of graves" required=""/>
        </label>
    </div>
    
    <div class="form-group">
        <label class="f-label">* Level:</label>
        <label class="block clearfix">
            <input type="number" name="level" class="form-control" 
                placeholder="Level" required=""/>
        </label>
    </div>
    
    <div class="form-group">
        <label class="f-label">* Type:</label>
        <label class="block clearfix">
            <select name="type" class="form-control" 
                placeholder="Level" required="">
                <option value=""> Select </option>
                <option value="public"> public </option>
                <option value="private"> private </option>
            </select>
        </label>
    </div>
    
    <button type="submit" class="btn btn-md btn-success"> SAVE </button>
    
</form>

                </div>
            </section>            
        </div>
        
    </div>
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>