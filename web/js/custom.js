$( function () {

	$( "[data-toggle='tooltip']" ).tooltip();
	// From http://stackoverflow.com/questions/121203/how-to-detect-if-javascript-is-disabled
	// search for "document.body.class" to find the solution:
	//  - set the <body> element's class via JavaScript. Default is .no-js.
	//   JavaScript sets it to .js
	// - all js/no-js CSS rules start with the respective <body> class, then  
	//   list the affected descendants
	document.body.className = document.body.className.replace( "no-js", "js" );
} )

function new_freecap() {
    // loads new freeCap image
    if(document.getElementById)
    {
        // extract image name from image source (i.e. cut off ?randomness)
        thesrc = document.getElementById("freecap").src;
        thesrc = thesrc.substring(0,thesrc.lastIndexOf(".")+4);
        // add ?(random) to prevent browser/ISP caching
        document.getElementById("freecap").src = thesrc+"?"+Math.round(Math.random()*100000);
    } else {
        alert("Sorry, cannot autoreload freeCap image\nSubmit the form and a new freeCap will be loaded");
    }
}
