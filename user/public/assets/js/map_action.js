(function() {
    var $section = $('#map_wrapper').first();
            $section.find('.panzoom').panzoom({
            minScale: 0.5,
            maxScale: 5,
            $zoomIn: $section.find(".zoom-in"),
            $zoomOut: $section.find(".zoom-out"),
            $zoomRange: $section.find(".zoom-range"),
            $reset: $section.find(".reset"),
          });
})();

$(document).ready(function() {

    var searchItem = {

        placePointer: function(parentElem) {

            var pointer = $('#pointer');
            var position = parentElem.offset();
            var pointerTopPosition = parseInt(position.top) - 35;
            var pointerLeftPosition = parseInt(position.left) - 10;
            
            pointer.css({'border': '1px solid red'});
            pointer.css({top: pointerTopPosition + 'px', left : pointerLeftPosition + 'px', display : 'block'});            
        }                
    };
    
    var searchItemIdVal = $('#search-item-id').val();
    
    $.ajax({
        url: "/?page=ajax-search&itemId=" + searchItemIdVal,
        //data: data,
        method : "GET",
        dataType: "json",

        error: function(response) {

        },

        beforeSend: function() {
            $('#map-loader').css('display', 'block');                    
        },

        complete: function(){                    

        },

        success: function(response) {

            var item = $('#' + response.graveCode);            
            searchItem.placePointer(item); 
            $('#map-loader').css('display', 'none');
        }     
    });   
});