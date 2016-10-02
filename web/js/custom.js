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

function startTest() {
	// set run percent value, always. Set it to 100 for all tests
	curr_st_formval = document.testform.run_option;
	curr_st_val = curr_st_formval.value;
	if (curr_st_val === undefined) {
		curr_st_val = getSelGBText("run_option");
	}
	curr_st = curr_st_val.substring(curr_st_val.indexOf('run_') + 4);
	cust_pct_txt = document.getElementById('cust_runpct').value;
	runpct = '100'; //assume only non-numeric case
	if (curr_st != 'all') {
		if (curr_st == 'cust') {
			runpct = cust_pct_txt;
		} else {
			runpct = curr_st;
		}
	}
	document.getElementById("run_pct").value = runpct;

	// set fail percent value, always. Set it to 0 for expected passes
	curr_st_formval = document.testform.fail_option;
	curr_st_val = curr_st_formval.value;
	if (curr_st_val === undefined) {
		curr_st_val = getSelGBText("fail_option");
	}
	curr_st = curr_st_val.substring('exp_'.length);
	cust_pct_txt = document.getElementById('cust_failpct').value;
	failpct = '0'; //assume all pass desired
	if (curr_st != 'pass') {
		curr_st = curr_st.substring(5);
		if (curr_st == 'cust') {
			failpct = cust_pct_txt;
		} else {
			failpct = curr_st;
		}
	}
	document.getElementById("fail_pct").value = failpct;
	//alert('https://bbaero.freeddns.org/runtest.php?runpct='+runpct+'&failpct='+failpct+'--end--');
	window.open('https://bbaero.freeddns.org/projects/chem/balancer/runtest.php?runpct='+runpct+'&failpct='+failpct, '_self', false);
}

function getSelGBText(gb_name) {
	var re = null;
	if (gb_name == "fail_option") {
		re = /exp_/g;
	} else if (gb_name == "run_option") {
		re = /^/g;
	} else {
		console.log("Unknown group box name '" + gb_name + "'!!");
		return null;
	}
	var rb = document.querySelector('input[name = "' + gb_name +
			'"]:checked');
	var st = rb.value;
	return st.replace(re, 'gbt_');
}

function showIDHideOthers(dispID, container, chClassesOrTag) {
	var cntr = document.querySelector(container);
	if (cntr === undefined || cntr == null) {
		/*console.log('Container "'+container+'" not found. ' +
			"Defaulting to document as container.");*/
		cntr = document;
	}
	var childelems;
	if (chClassesOrTag.search('\.[A-Za-z]') >= 0) {
		childelems = cntr.getElementsByClassName(chClassesOrTag.substring(1));
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

function PollingHttpReq() {}

// static properties
if (typeof PollingHttpReq.xhr == 'undefined') {
	PollingHttpReq.xhr = null;
}

if (typeof PollingHttpReq.obs == 'undefined') {
	PollingHttpReq.obs = null;
}

if (typeof PollingHttpReq.intervalID == 'undefined') {
	PollingHttpReq.intervalID = 0;
}

if (typeof PollingHttpReq.last_reply_len == 'undefined') {
	PollingHttpReq.last_reply_len = 0;
}

PollingHttpReq.startObserver = function(elemid) {
	console.log("starting observer...");
	try {
		obs = new MutationObserver(function(mutations) {
		  mutations.forEach(function(mt) {
			  console.log(new Date().toLocaleString() + " mt is");
			  console.log(mt);
			  console.log("");
			  if (mt.type === "childList") {
				console.log("Caling stopPoll...");
				PollingHttpReq.stopPoll(elemid, "See results");
			  }
		  });
		});
		obs.observe(document.getElementById(elemid), {childList: true});
		console.log("observer started!");
	} catch (e) {
		console.log("do nothing");
	}
}

// status methods. Must follow class definition
PollingHttpReq.sendReq = function(http_method, url, reqparms, elemid) {
	PollingHttpReq.xhr = new XMLHttpRequest();
	var started = false;
	var hmeth = http_method;
	var resptype = "text";
	// if method is given as "<method>:<rtype>", e.g., "GET:document", then
	// set the reqeusted doc type and http method
	methresp = hmeth.split(":");
	if (methresp.length > 1) {
		hmeth = methresp[0];
		resptype = methresp[1];
	}
	realreqparms = reqparms + "&ts=" + (new Date().getTime());
	PollingHttpReq.xhr.responseType = resptype;
	if (hmeth === "POST") {
		PollingHttpReq.xhr.open(hmeth, url, true);
		PollingHttpReq.xhr.setRequestHeader("Content-type",
			"application/x-www-form-urlencoded");
		PollingHttpReq.xhr.send(realreqparms);
	} else {
		PollingHttpReq.xhr.open(hmeth, url + "?" + realreqparms, true);
		PollingHttpReq.xhr.send();
	}
	var elem = null;
	PollingHttpReq.xhr.onreadystatechange = function(){
		console.log(new Date().toLocaleString() + " xhr ready state " +
			"is ", PollingHttpReq.xhr.readyState);
		if (PollingHttpReq.xhr.readyState == 3) {
			elem = document.getElementById(elemid);
			xhr_resp = PollingHttpReq.xhr.response;
			if (xhr_resp == null || xhr_resp == "null") {
				xhr_resp = "";
			}
			console.log(new Date().toLocaleString() +
				" XHR response: ", xhr_resp);
			elem.innerHTML = xhr_resp;
			PollingHttpReq.stopPoll(elemid, "See results");
		} else if (PollingHttpReq.xhr.readyState == 4) {
			if (PollingHttpReq.xhr.status == 200) {
			var waitbanner = document.getElementById("testwait");
			var bannertop = waitbanner.style.top;
			var bannerleft = waitbanner.style.left;
			waitbanner.style.display = 'none';
			var donebanner = document.getElementById("testdone");
			donebanner.style.top = bannertop;
			donebanner.style.left = bannerleft;
			donebanner.style.display = "inline-flex";
			// for browsers that do not support inline-flex, use
			// inline-block instead
			if (donebanner.style.display == 'none') {
				donebanner.style.display = "inline-block";
			}
			console.log(new Date().toLocaleString() + " should " +
				"see done banner.");
			xhr_resp = PollingHttpReq.xhr.response;
			if (xhr_resp == null || xhr_resp == "null") {
				xhr_resp = "";
			}
			elem.innerHTML = xhr_resp;
			}
		}
	};
	if (!started) {
		PollingHttpReq.intervalID = setInterval(
				PollingHttpReq.xhr.onreadystatechange, 1000);
		started = true;
	}
}

PollingHttpReq.stopPoll = function(elemid, stop_phrase) {
	raw_html = document.getElementById(elemid).innerHTML;
	cur_str = raw_html.substring(PollingHttpReq.last_reply_len);
	console.log(new Date().toLocaleString() + " curstr is " + cur_str);
	if (cur_str.indexOf(stop_phrase) >= 0) {
		console.log("Clearing interval");
		clearInterval(PollingHttpReq.intervalID);
	}
	PollingHttpReq.last_reply_len = raw_html.length;
}

function getAsyncTestStatus(tbl_id, runpct, failpct) {
	url = "/chemtestpage/TestRunner";
	parms = "runpct=" + runpct + "&failpct=" + failpct;
	console.log("Parms are " + parms);
	PollingHttpReq.sendReq("POST", url, parms, tbl_id);
}

function getSyncTestStatus(tbl_id, runpct, failpct) {
	url = "/chemtestpage/TestRunner";
	parms = "runpct=" + runpct + "&failpct=" + failpct;
	PollingHttpReq.sendReq("GET", url, parms, tbl_id);
}
