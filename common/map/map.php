<link href="../admin/template/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../common/map/map_style.css" rel="stylesheet" type="text/css" />

<div id="map_wrapper" class="row">
    
    <div class="panzoom">    
        <?php include_once '../map/map_svg.php'; ?>    
    </div>   
    <div id="map-left-sidebar">
        
        <div id="map_search_wrapper">
            <form>
                <input type="text" placeholder="Search a grave...">
                <button type="button">Search</button>
            </form>            
        </div>
      
      <div class="controls">
        <div class="buttons">
          <button class="zoom-in"> + <!--Zoom In--></button>
          <button class="zoom-out"> - <!--Zoom Out--></button>
          <input type="range" class="zoom-range">
          <button class="reset">Reset</button>
        </div>
      </div>
    </div>
    
<div class="modal fade" tabindex="-1" role="dialog" id='add_item'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Question</h4>
      </div>
      <div class="modal-body">
      
          
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
</div>

<!-- Scripts -->
<script src="../user/template/assets/js/jquery.min.js"></script> 
<script src="../admin/template/js/bootstrap.min.js"></script> 
<script src="../public/plugins/timmywil-jquery.panzoom/dist/jquery.panzoom.js"></script>
<script type="text/javascript">

(function() {
    var $section = $('#map_wrapper').first();
            $section.find('.panzoom').panzoom({
            minScale: 0.5,
            maxScale: 5,
            $zoomIn: $section.find(".zoom-in"),
            $zoomOut: $section.find(".zoom-out"),
            $zoomRange: $section.find(".zoom-range"),
            $reset: $section.find(".reset")
          });
})();


$(document).ready(function() {
    
    $('rect').click(function() {
        
        console.log($(this).attr('id'));
        $('#add_item').modal('show');
        
    });    
});

</script>