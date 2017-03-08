$(document).ready(function() {
    
   
    var colorRed = '#ef1d3b'; 
    var selectedGrave = $("#selectedGrave").val();
    var mapWrapper = $('#user-map-search-result');
    var graveEl = $('#' + selectedGrave);
    var graveElOffset = graveEl.offset();
    var svgPointerEl = $('#svg_pointer');
    
    graveEl.attr('fill', colorRed);
    
    var leftVal = graveElOffset.left - 450 + 'px';
    var topVal = graveElOffset.top - 220 + 'px';
    
    mapWrapper.animate({
        scrollLeft: leftVal,
        scrollTop: topVal
        }, 1000);
        
    svgPointerEl.css({top: graveElOffset.top - 40 + 'px', left: graveElOffset.left - 10 + 'px'});
    
    svgPointerEl.on('click', function() {
        
        var showImagesModal = $('#show_images');
        
        showImagesModal.modal('show');
        
    });
        
 
});