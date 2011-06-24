function setCoords(c) {
    jQuery('#x').val(c.x);
    jQuery('#y').val(c.y);
    jQuery('#x2').val(c.x2);
    jQuery('#y2').val(c.y2);
    jQuery('#w').val(c.w);
    jQuery('#h').val(c.h);
}

var $j = jQuery.noConflict();
$j(window).load(function() {

$j.Jcrop('#cropthis', {
    boxWidth:500,
    boxHeight: 500,
    aspectRatio: 1,
    onChange: setCoords,
    onSelect: setCoords
});

});
