<?php
$actId = isset($_GET['id']) ? $_GET['id'] : 0; 
$data= $activity->updateActivity($actId);

if ($data['isUpdated']) {
    header("Location:../". constant(BASE_URL) . 'admin/?page=dashboard');      
}

include_once 'template/header.php';
include_once 'template/sidebar.php'; 

?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
    <div class="row">
        
        <div class="col-md-12">            
            <section class="panel">
                <header class="panel-heading">
                    Edit Activity
                </header>
                <div class="panel-body">     

                    <form class="form-horizontal col-lg-10 col-centered" name="add-form" method="POST" action="<?php echo BASE_URL . '/admin/?page=editactivity&id=' . $actId ?>">
                    
                    <div class="col-lg-12">
                                                
                        <div class="form-group">
                            <label class="f-label">* Title:</label>
                            <label class="block clearfix">
                                <input type="text" name="title" class="form-control" required="" value="<?php echo $data['data']['title'] ?>"/>
                            </label>
                        </div>                       
                                                
                        <div class="form-group">
                            <label class="f-label"> Description:</label>
                            <label class="block clearfix">
                                <textarea name="description" class="form-control" required=""/><?php echo $data['data']['description'] ?></textarea>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Date:</label>
                            <label class="block clearfix">
                                <input type="text" name="date" class="form-control" required="" value="<?php echo $data['data']['date'] ?>"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-success"> Save </button>
                            <a href="?page=dashboard" class="btn btn-sm btn-success"> Cancel </a>
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