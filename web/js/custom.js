var redraw_footer = false;

function footer_list_width () {
    var list_width = 0;
    var total_footer_padding = 102;

    $( "footer li span img, footer li span .footer-text" ).each( function() {
            list_width += $( this ).width();
    } );

    //console.log( list_width + total_footer_padding );
    return list_width + total_footer_padding;
};

$( function () {

	$( "[data-toggle='tooltip']" ).tooltip();
	// From http://stackoverflow.com/questions/121203/how-to-detect-if-javascript-is-disabled
	// search for "document.body.class" to find the solution:
	//  - set the <body> element's class via JavaScript. Default is .no-js.
	//   JavaScript sets it to .js
	// - all js/no-js CSS rules start with the respective <body> class, then  
	//   list the affected descendants
	document.body.className = document.body.className.replace( "no-js", "js" );
    if ( $("footer.footer").css( "display" ) != "none" ) {
        enquire.register( "screen and ( min-width : 992px )", {
            match : function() {
                if ( redraw_footer ) {
                    $( "footer div.container" ).css( "width",
                             footer_list_width() );
                }
            },
            unmatch : function() {
                if ( redraw_footer ) {
                    $( "footer div.container" ).css( "width",
                             footer_list_width() );
                }
            }
        });
    }
    
    // must not redraw earlier than here. Otherwise footer's container
    // div's width is less than the maximum
    $( "footer div.container" ).css( "width" , footer_list_width() );
    redraw_footer = true;

} )
