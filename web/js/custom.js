$( function () {
	$( "[data-toggle='tooltip']" ).tooltip();
	// From http://stackoverflow.com/questions/121203/how-to-detect-if-javascript-is-disabled
	// search for "document.body.class" to find the solution:
	//  - set the <body> element's class via JavaScript. Default is .no-js.
	//   JavaScript sets it to .js
	// - all js/no-js CSS rules start with the respective <body> class, then  
	//   list the affected descendants
	document.body.className = document.body.className.replace( "no-js", "js" );
} );