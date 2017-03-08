<?php 

$activities = $activity->findAll();
$data = $activities;

if ($data['inlineAction'] == 'deleted' || $data['inlineAction'] == 'published' || $data['inlineAction'] == 'unpublished') {
    header("Location:../". constant(BASE_URL) . 'admin/?page=dashboard');      
}

include_once 'template/header.php';
include_once 'template/sidebar.php';

?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
    <div class="row">
        
        <div class="col-md-12">  
            <a href="<?php echo BASE_URL . '/admin/?page=newactivity' ?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle"></i> New Activity
            </a>
            <h4 class="divider"></h4>
        </div>
        
        <div class="col-md-12">            
            <section class="panel">
                <header class="panel-heading">
                    Activities
                </header>
                <div class="panel-body">     
                    
                    
<table border="0" class="table table-condensed">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Status</th>
            <th width="170px"> Actions </th>
        </tr>
    <?php foreach($data['data'] as $result) { ?>
        <tr>
            <td> <?php echo $result['title'] ?> </td>
            <td> <?php echo $result['description'] ?> </td>
            <td> <?php echo date("M d, Y", strtotime($result['date'])); ?> </td>
            <td> <?php echo $result['status'] ?>  </td>
            <td style="display: relative">
                
                <?php if ($result['status'] == 'unpublished') { ?>
                <form class="form-action-inline" method="POST" action="<?php echo BASE_URL . '/admin/?page=dashboard' ?>">                    
                    <input type="hidden" name="inline_action" value="publish">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger btn-success"><i class="fa fa-thumbs-up"></i></button>
                </form>
                <?php } ?>
                
                <?php if ($result['status'] == 'published') { ?>
                <form class="form-action-inline" method="POST" action="<?php echo BASE_URL . '/admin/?page=dashboard' ?>">                    
                    <input type="hidden" name="inline_action" value="unpublished">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger btn-success"><i class="fa fa-arrow-down"></i></button>
                </form>
                <?php } ?>
                
                
                <form class="form-action-inline" onsubmit="return alertConfirmation(this, 'Are you sure you want to delete this Activity?')" method="POST" action="<?php echo BASE_URL . '/admin/?page=dashboard' ?>">                    
                    <input type="hidden" name="inline_action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger btn-success"><i class="fa fa-times"></i></button>
                </form>
                <a href="<?php echo BASE_URL . '/admin/?page=editactivity&id='.$result['id'] ?>" class="btn btn-sm btn-primary btn-success"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
    <?php } ?>
</table>
                    
<div class="col-md-12 page-content-header" style="text-align: right">
    <?php echo $data['pagination']  ?>
</div>
                    
                    

                </div>
            </section>            
        </div>       
        
    </div>
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>