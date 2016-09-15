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

function showWaitAndTest() {
	// set percent value, always. Set it to 0 for expected passes
	curr_st_formval = document.testform.suite_type;
	curr_st_val = curr_st_formval.value;
	if (curr_st_val === undefined) {
		curr_st_val = getCurrGBDetailText();
	}
	curr_st = curr_st_val.substr('exp_'.length);
	cust_pct_txt = document.getElementById('cust_pct').value;
	pct = '0'; //assume all pass desired
	if (curr_st != 'pass') {
		curr_st = curr_st.substr(5);
		if (curr_st == 'cust') {
			pct = cust_pct_txt;
		} else {
			pct = curr_st;
		}
	}
	document.getElementById("fail_pct").value = pct;
	//alert('https://bbaero.freeddns.org/chemtestpage/TestRunner?pct='+pct+'--end--');
	// show waiting icon, then start tests
	document.getElementById("testwait").style.display = 'block';
	//window.open ('https://bbaero.freeddns.org/chemtestpage/TestRunner?pct='+pct,'_self',false);
}

function getCurrGBDetailText() {
	var rb = document.querySelector('input[name = "suite_type"]:checked');
	var st = rb.value;
	var re = /exp_/g;
	return st.replace(re, 'gbt_');
}

function showIDHideOthers(dispID, container, chClassesOrTag) {
	var cntr = document.querySelector(container);
	if (cntr === undefined) {
		console.log('Container "'+container+'" not found. ' +
			"Defaulting to document as container.");
		cntr = document;
	}
	var childelems;
	if (chClassesOrTag.search('\.[A-Za-z]') >= 0) {
		childelems = cntr.getElementsByClassName(chClassesOrTag.substr(1));
	} else {
		childelems = cntr.getElementsByTagName(chClassesOrTag);
	}
	for (var curkid = 0; curkid < childelems.length; curkid++) {
		if (childelems[curkid].id == dispID) {
			childelems[curkid].style.display = 'inherit';
		} else {
			childelems[curkid].style.display = 'none';
		}
	}
}
