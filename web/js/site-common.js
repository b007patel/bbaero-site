var errFound;
var debugOn = true;
var pgroot = "<unknown>";

$( function () {

    $( "[data-toggle='tooltip']" ).tooltip();
    // From
    // http://stackoverflow.com/questions/121203/how-to-detect-if-javascript-is-disabled
    // search for "document.body.class" to find the solution:
    //  - set the <body> element's class via JavaScript. Default is .no-js.
    //   JavaScript sets it to .js
    // - all js/no-js CSS rules start with the respective <body> class,
    //   then list the affected descendants
    document.body.className = document.body.className.replace( "no-js", "js" );
    if (pgroot == "<unknown>") getUrlBase();
} )

dlog = console.log.bind(console);
if (!debugOn) {
    dlog = function() {};
} 

if (typeof(Number.parseInt) == 'undefined') { Number.parseInt = parseInt; }
// Inheritance shim from
// http://www.crockford.com/javascript/inheritance.html#sugar
Function.prototype.method = function (name, func) {
    this.prototype[name] = func;
    return this;
};

Function.method('inherits', function (parent) {
    this.prototype = new parent();
    var d = {}, p = this.prototype;
    this.prototype.constructor = parent;
    this.method('uber', function uber(name) {
        if (!(name in d)) {
            d[name] = 0;
        }        
        var f, r, t = d[name], v = parent.prototype;
        if (t) {
            while (t) {
                v = v.constructor.prototype;
                t -= 1;
            }
            f = v[name];
        } else {
            f = p[name];
            if (f == this[name]) {
                f = v[name];
            }
        }
        d[name] += 1;
        r = f.apply(this, Array.prototype.slice.apply(arguments, [1]));
        d[name] -= 1;
        return r;
    });
    return this;
});

// optional argument output_wbelem is the CSS ID of a web element to
// display the URL base found by this function
function getUrlBase(output_wbelem) {
    raw_base = window.location.href;
    // find first '/' after initial 'http[s]://' '/'s
    slash_index = raw_base.search(/[A-Za-z]\/[0-9A-Za-z]/g) + 1;
    urlbase = raw_base.slice(0, slash_index + 1);
    pgroot = urlbase;
    noelem = (output_wbelem === undefined || output_wbelem == null);
    if (!noelem) {
        noelem = output_wbelem.length < 1;
    }
    if (!noelem) {
        document.getElementById(output_wbelem).value = urlbase;
    }
}

function new_freecap() {
    // loads new freeCap image
    if(document.getElementById) {
        // extract image name from image source (i.e. cut off ?randomness)
        thesrc = document.getElementById("freecap").src;
        thesrc = thesrc.substring(0,thesrc.lastIndexOf(".")+4);
        // add ?(random) to prevent browser/ISP caching
        document.getElementById("freecap").src = thesrc+"?"+Math.round(Math.random()*100000);
    } else {
        alert("Sorry, cannot autoreload freeCap image\nSubmit the form and a new freeCap will be loaded");
    }
}

function xhrLoadPage(newurl) {
    lpxhr = new XMLHttpRequest();
    lpxhr.open("GET", newurl);
    lpxhr.send();
    // because time for loading is unknown, must place code using response
    // in the onload event
    lpxhr.onload = function() {
        rawdoc = lpxhr.responseText;
        newdoc = (new DOMParser()).parseFromString(rawdoc, "text/html");
        blankdoc = (newdoc === undefined || newdoc == null);
        blankdoc = blankdoc || rawdoc.length < 1;
        if (blankdoc) {
            console.log("xhrLoadPage() - got blank XHR response!");
        } else {
            document.getElementsByTagName("title")[0].text =
                    newdoc.getElementsByTagName("title")[0].text;
            // show expected HTML elements
            newdoc.body.className = newdoc.body.className.replace( "no-js",
                    "js" );
            document.body = newdoc.body;
            if (pgroot == "<unknown>") getUrlBase();
            // checking newdoc.<script>'s gives 0 tags, but this works with
            // document.<script>'s
            script_tags = document.getElementsByTagName("script");
            // run any immediate JS calls in the HTML, if given
            for (cs=0; cs < script_tags.length; cs++) {
                if (script_tags[cs].innerHTML.length > 0) {
                    eval(script_tags[cs].innerHTML);
                }
            }
        }
    };
}

function changeClassListForClass(clsIn, modClass) {
    addClass = modClass[0] == '+';
    modClass = modClass.substring(1);
    classElems = document.getElementsByClassName(clsIn);
    for (var ce=0; ce < classElems.length; ce++) {
        if (addClass) {
            classElems.item(ce).classList.add(modClass);
        } else {
            classElems.item(ce).classList.remove(modClass);
        }
    }
}

function showXHRError(errmsg) {
    err_div = document.getElementById("xhrerrs")
    makeNewDiv = (err_div === undefined || err_div == null);
    if (makeNewDiv) {
        err_div = document.createElement("div");
        err_div.setAttribute("id", "xhrerrs");
    }
    err_div.innerHTML = "ERROR! " + errmsg + "!!<br>\n";
    top_div = document.getElementById("test-wait");
    if (top_div === undefined || top_div == null) {
        top_div = document.getElementById("queue-wait");
    }
    err_div.innerHTML += "** WEB SERVER IN BAD STATE! STOPPING TESTING! **" +
            "<br>\n";
    if (makeNewDiv) { top_div.insertAdjacentElement("beforeBegin", err_div); }
    errFound = true;
}

function winErrorHandler(errorMsg, url, lineNumber, column, errorObj) {
    xmlErrorFound = false;
    topElem = document.getElementById("test-wait");
    xmlErrorFound = topElem !== undefined && topElem != null;
    if (!xmlErrorFound) {
        topElem = document.getElementById("queue-wait");
        xmlErrorFound = topElem !== undefined && topElem != null;
    }
    console.log("win on-Error: ", errorMsg, " : ", url, " : ", lineNumber,
        " : ", column, " : ", errorObj.toString(), " : xmlErrorFound? ",
        xmlErrorFound);
    if (xmlErrorFound) {
        showXHRError(errorObj.toString());
    }
}


function PollingHttpReq() {}

PollingHttpReq.protoype = {
    init: function() {
        errFound = false;
        this.intervalId = 0;
        dlog("Interval ID is", this.intervalID);
        /* for startObserver
        this.obs = null;*/
    }
}

/* The startObserver function has been commented out because old browsers
(i.e., Blackberry OS 10) do not support MutationObservers.
PollingHttpReq.method('startObserver', function(elemid) {
    dlog("starting observer...");
    try {
        this.obs = new MutationObserver(function(mutations) {
          mutations.forEach(function(mt) {
              dlog(new Date().toLocaleString() + " mt is");
              dlog(mt);
              dlog("");
              if (mt.type === "childList") {
                dlog("Caling stopPoll...");
                this.stopPoll(elemid, "See results");
              }
          });
        });
        this.obs.observe(
            document.getElementById(elemid), {childList: true});
        dlog("observer started!");
    } catch (e) {
        dlog("do nothing");
    }
});*/

PollingHttpReq.method('doHttpAction', function(xhr, http_method, url,
        reqparms, topID) {
    var hmeth = http_method;
    var resptype = "text";
    if (reqparms.search("pos") > 0) {
        dlog("pos parm is in ", reqparms);
    }
    // if method is given as "<method>:<rtype>", e.g., "GET:document", then
    // set the reqeusted doc type and http method
    methresp = hmeth.split(":");
    if (methresp.length > 1) {
        hmeth = methresp[0];
        resptype = methresp[1];
    }
    hmeth = hmeth.toLowerCase();
    realreqparms = reqparms + "&ts=" + (new Date().getTime());
    realurl = url + "?" + realreqparms;
    try {
        xhr.responseType = resptype;
    } catch (e) {
        dlog("==> ", e.name, " : ", e.message);
        if (e.name.toLowerCase().search(/invalid.*state.*err/) < 0) {
            xhr.abort();
            showXHRError(e.toString());
        } // else the state was not at 1(OPENED) long enough to set hdrs
    }
    dlog(hmeth, " ", realurl, " ", realreqparms);
    if (hmeth == "post") {
        xhr.open(hmeth, realurl, true);
        try {
            if (xhr.readyState > 1) {
                xhr.setRequestHeader("Content-type",
                        "application/x-www-form-urlencoded");
	        xhr.send(realreqparms);
            } else {
                xhr.send();
            }
        } catch (e) {
            dlog("==> ", e.name, " : ", e.message);
            if (e.name.toLowerCase().search(/invalid.*state.*err/) < 0) {
                xhr.abort();
                showXHRError(e.toString());
            } // else the state was not at 1(OPENED) long enough to set hdrs
        }
    } else { //hmeth == "get"
        try {
            xhr.open(hmeth, realurl, true);
            xhr.send();
        } catch (e) {
            dlog("==> ", e.name, " : ", e.message);
            if (e.name.toLowerCase().search(/invalid.*state.*err/) < 0) {
                xhr.abort();
                showXHRError(e.toString());
            } // else the state was not at 1(OPENED) long enough to set hdrs
        }
    }
    return xhr.status;
});

PollingHttpReq.method('sendReq',
        function(http_method, url, reqparms, elemid) {
    // abstract method to be implemented by descendants
});

PollingHttpReq.method('stopPoll', function(elemid, raw_stop_phrases) {
    // abstract method to be implemented by descendants
});

