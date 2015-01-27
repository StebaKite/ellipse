$( "#menu-accordion" ).accordion({
	active: false,
	collapsible: true
});

var formatDateJQ="dd/mm/yy";

$( ".button" ).button();
$( ".radioset" ).buttonset();


$( ".tabs" ).tabs({ width: 400 });


$( "#dialog" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
});

// Link to open the dialog
$( ".dialog-link" ).click(function( event ) {
	$( "#dialog" ).dialog( "open" );
	event.preventDefault();
});



$( ".datepicker" ).datepicker({
	changeMonth: true,
	changeYear: true,
	bgiframe: true,
	dateFormat: formatDateJQ,
	constrainInput: true,
	maxDate: "10y",
	minDate: "-50y"
});

$( ".data" ).datepicker({
	inline: true,
	changeMonth: true,
	changeYear: true,
	bgiframe: true,
	dateFormat: formatDateJQ,
	constrainInput: true
});


$( "#slider" ).slider({
	range: true,
	values: [ 17, 67 ]
});



$( "#progressbar" ).progressbar({
	value: 20
});



$( "#spinner" ).spinner();



$( "#menu" ).menu();



$( ".tooltip" ).tooltip();



$( ".selectmenu" ).selectmenu();

$( "#selectmenu1" )
	.selectmenu()
	.selectmenu("menuWidget")
	.addClass("overflow");

$( "#selectmenu2" )
	.selectmenu()
	.selectmenu("menuWidget")
	.addClass("overflow");

$( "#selectmenu3" )
	.selectmenu()
	.selectmenu("menuWidget")
	.addClass("overflow");

$( "#selectmenu4" )
	.selectmenu()
	.selectmenu("menuWidget")
	.addClass("overflow");

$( "#selectmenu5" )
	.selectmenu()
	.selectmenu("menuWidget")
	.addClass("overflow");

$( "#selectmenu6" )
	.selectmenu()
	.selectmenu("menuWidget")
	.addClass("overflow");


$( "#vtabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
$( "#vtabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );


// Hover states on the static widgets
$( "#dialog-link, #icons li" ).hover(
	function() {
		$( this ).addClass( "ui-state-hover" );
	},
	function() {
		$( this ).removeClass( "ui-state-hover" );
	}
);

var vociListino = ["  "];	

$( ".autocomplete" ).autocomplete({
	source: vociListino
});


$(function() {
	$('tr.parent') 
		.css("cursor","pointer") 
		.attr("title","Click per espandere/collassare") 
		.click(function(){
			$(this).siblings('.child-'+this.id).toggle();
		});
	$('tr[@class^=child-]').hide().children('td');
});
