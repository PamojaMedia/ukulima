$(document).ready(function(){
	$("#delayed-drops .nav-item").hoverIntent({
		interval: 150, // milliseconds delay before onMouseOver
		over: drops_show, 
		timeout: 500, // milliseconds delay before onMouseOut
		out: drops_hide
	});
});
function drops_show(){ $(this).addClass('show'); }
function drops_hide(){ $(this).removeClass('show'); }
