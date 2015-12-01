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
        
        enquire.register( "screen and ( min-height : 700px )", {
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
        
        // Sometimes footer container width is too narrow at page load.
        // Change it if it is.
        var min_width = 695; /* hardcoded width of 75px min width images */
        if ( $( "a#comodoTL" ).height() < 75 ) {
            min_width = 558;
        }
        $( "footer div.container" ).css( "width" , min_width )
        redraw_footer = true;
    }

} )
