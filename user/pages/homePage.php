<?php

$activities = $activity->findAll('published');

include_once 'user/template/header.php';
include_once 'user/template/nav.php';
include_once 'user/template/primaryContent.php';
?>

<div class="container">
    
    <div class="row">
        
        <div class="col-md-8">            
            <section class="activities">
                <header class="heading">
                    Activities
                    <h5 class="divider"></h5>
                </header>
                <div class="body">     

                <?php foreach($activities['data'] as $result) { ?>
                    <div class="list">
                        <div class="title"> <?php echo $result['title'] ?> </div>  
                        <div class="description"> <?php echo $result['description'] ?> </div>  
                        <div class="date"> <?php echo $result['date'] ?> </div>  
                    </div>
                <?php } ?>   

                </div>
            </section>            
        </div>
        
        <div class="col-md-4"> 
            
            <section class="panel">
                <header class="panel-heading">
                   
                </header>
                <div class="panel-body">     

                   

                </div>
            </section>
            
            <section class="panel">
                <header class="panel-heading">
                   
                </header>
                <div class="panel-body">     

                    
                </div>
            </section>
            
        </div>
        
    </div>
    
    
</div>

<?php include_once 'user/template/footer.php' ?>