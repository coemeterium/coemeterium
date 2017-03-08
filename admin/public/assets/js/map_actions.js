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