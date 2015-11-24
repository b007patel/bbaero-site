var footerHeight = -1;

var setLineHeightToHeight = function () {
	if ( $( ".footer" ).height() != footerHeight ) {  
		$( ".footer" ).css( "line-height", $( ".footer" ).css( "height" ) );
		footerHeight = $( ".footer" ).height();
	};
};

$( function () {
	  $( "[data-toggle='tooltip']" ).tooltip();
	  setLineHeightToHeight();
} );

$( window ).resize( function() {
	setLineHeightToHeight();
} );