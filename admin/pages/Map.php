<?php include_once 'template/header.php'; ?>
<?php include_once 'template/sidebar.php'; ?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
    <div class="row">        
        <div class="col-md-12">            
            <section class="panel">
                <header class="panel-heading">
                    Map
                </header>
                
                <div class="panel-body" id="map_wrapper">     

                    <div class="panzoom" style="border: 1px solid yellow;">    
                        <?php include_once '../map/map_svg.php'; ?>    
                    </div>    
                    <div class="controls">
                      <div class="buttons">
                        <button class="zoom-in">Zoom In</button>
                        <button class="zoom-out">Zoom Out</button>
                        <input type="range" class="zoom-range">
                        <button class="reset">Reset</button>
                        <button id="find_id">Find By Id</button>
                      </div>
                    </div>

                </div>
                
            </section>
        </div>        
    </div>
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>