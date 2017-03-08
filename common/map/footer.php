<!-- Scripts -->
<script src="../user/template/assets/js/jquery.min.js"></script> 
<script src="../public/plugins/timmywil-jquery.panzoom/dist/jquery.panzoom.js"></script> 

      <script>
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
      </script>
        
        <script>
            $(document).ready(function() {
               
               $('rect').on('click', function() {
                   console.log($(this).attr('id'));
               });
               
               $('#find_id').click(function() {
                   
                   console.log("Find Id"); 
                   var grave = $('#block-a-g1');
                       grave.css({fill: 'red'});
                       console.log(grave.offset());
                   
               });
                
            });
        </script>

    </body>
</html>