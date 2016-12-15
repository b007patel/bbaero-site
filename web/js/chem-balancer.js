var chembalroot = "https://bbaero.freeddns.org/projects/chem/balancer/";

function showQueueState(qstate) {
    hiddenStates = ['update', 'wait', 'go', 'err'];

    hiddenStates.splice(hiddenStates.indexOf(qstate), 1);
    for (var cs=0; cs < hiddenStates.length; cs++) {
        changeClassListForClass("qs-" + hiddenStates[cs], "+hidden");
        changeClassListForClass("qs-" + hiddenStates[cs], "-tbl-cell-show");
    }
    changeClassListForClass("qs-" + qstate, "+tbl-cell-show");
    changeClassListForClass("qs-" + qstate, "-hidden");
}

function enqueueTest() {
    cur_pg = location.href;
    // set run percent value, always. Set it to 100 for all tests
    curr_st_formval = document.testform.runoption;
    curr_st_val = curr_st_formval.value;
    if (curr_st_val === undefined) { curr_st_val = getSelGBText("runoption"); }
    curr_st = curr_st_val.substring(curr_st_val.indexOf('run') + 4);
    cust_pct_txt = document.getElementById('cust-runpct').value;
    runpct = '100'; //assume only non-numeric case
    if (curr_st != 'all') {
        if (curr_st == 'cust') { runpct = cust_pct_txt;
        } else { runpct = curr_st; }
    }
    if (runpct === undefined || runpct == null ||
            runpct == "null" || runpct.trim() == "") {
        location.href = cur_pg;
        return;
    }
    document.getElementById("run-pct").value = runpct;

    // set fail percent value, always. Set it to 0 for expected passes
    curr_st_formval = document.testform.failoption;
    curr_st_val = curr_st_formval.value;
    if (curr_st_val === undefined) { curr_st_val = getSelGBText("failoption"); }
    curr_st = curr_st_val.substring('exp-'.length);
    cust_pct_txt = document.getElementById('cust-failpct').value;
    failpct = '0'; //assume all pass desired
    if (curr_st != 'pass') {
        curr_st = curr_st.substring(5);
        if (curr_st == 'cust') { failpct = cust_pct_txt;
        } else { failpct = curr_st; }
    }
    if (failpct === undefined || failpct == null ||
            failpct == "null" || failpct.trim() == "") {
        location.href = cur_pg;
        return;
    }
    document.getElementById("fail-pct").value = failpct;
    location.href = chembalroot + 'test-request.php?runpct=' + runpct +
            '&failpct='+failpct;
}

function getSelGBText(gb_name) {
    var re = null;
    if (gb_name == "failoption") { re = /exp-/g;
    } else if (gb_name == "runoption") { re = /^/g;
    } else { dlog("Unknown group box name '" + gb_name + "'!!"); return null; }
    var rb = document.querySelector('input[name = "' + gb_name + '"]:checked');
    var st = rb.value.replace(/_/g, "-");
    return st.replace(re, 'gbt-');
}

function showIDHideOthers(dispID, container, chClassesOrTag) {
    var cntr = document.querySelector(container);
    if (cntr === undefined || cntr == null) { cntr = document; }
    var childelems;
    if (chClassesOrTag.search('\.[A-Za-z]') >= 0) {
        childelems = cntr.getElementsByClassName(chClassesOrTag.substring(1));
    } else { childelems = cntr.getElementsByTagName(chClassesOrTag); }
    for (var curkid = 0; curkid < childelems.length; curkid++) {
        if (childelems[curkid].id == dispID) {
            childelems[curkid].style.display = 'inherit';
        } else { childelems[curkid].style.display = 'none'; }
    }
}

function TestPollHttpReq() {}

TestPollHttpReq.inherits(PollingHttpReq);

function TestPollHttpReq() {
    this.refreshPeriod = 5; this.currInterval = 0; this.startTime = "";
    this.runDone = false; this.logurl = ""; this.logsButRunning = false;
    this.tblxhr = new XMLHttpRequest();
}

TestPollHttpReq.method("updateContent", function(xhr, elem, prevhtml) {
    xhr_resp = xhr.response;
    if (xhr_resp == null || xhr_resp == "null") { xhr_resp = ""; }
    dlog(new Date().toLocaleString() + " XHR response: ", xhr_resp);
    // to prevent flashing on older devices. Also to hang onto results
    // when done testing
    if (prevhtml != xhr_resp && xhr_resp.length > prevhtml.length) {
        elem.innerHTML = xhr_resp;
    }
});

TestPollHttpReq.method("getStartTime", function(rawresp, label_pos) {
    start_pos = label_pos - "20XX-XX-XX, XX:XX:XX UTC".length;
    tslen = "20XX-XX-XX, XX:XX:XX".length;
    rawstart = rawresp.substring(start_pos, start_pos + tslen);
    dlog("rawstart:", rawstart);
    this.startTime = rawstart.replace(/, /, "-");
    dlog("1st startTime:", this.startTime);
    st_parts = this.startTime.split(":");
    this.startTime = st_parts[0] + "_" + st_parts[1] + "-" + st_parts[2];
    dlog("getStartTime got", this.startTime);
});

TestPollHttpReq.method("getRunLog", function(start_time) {
    var trun = this;
    loghome = "https://bbaero.freeddns.org/testlogs/";
    this.tblxhr.open("GET", loghome + "?C=M;O=D"); this.tblxhr.send();
    this.tblxhr.onload = function() {
        rawtbl = trun.tblxhr.responseText;
        dlog("rawtbl length is", rawtbl.length);
        trun.tblxhr.abort(); parser = new DOMParser();
        tlogtbl = parser.parseFromString(rawtbl, "text/html");
        tlog_row = tlogtbl.getElementsByClassName("odd")[0];
        tlog_col = tlog_row.getElementsByClassName("indexcolname")[0];
        tlog_coltext = tlog_col.getElementsByTagName("a")[0].text;
        if (tlog_coltext.search(start_time) > 0) {
            trun.logurl = loghome + tlog_coltext + "index.html";
            dlog("Log URL is now", trun.logurl);
        }
    };
});

TestPollHttpReq.method("getUpdate", function(xhr, http_method,
        url, reqparms) {
    if (errFound === undefined || errFound == null) { errFound = false; }
    if (errFound) {
        dlog("TestPoll stop sending getUpdates! Need this in case error " +
                "stops clearInterval() from working!!");
        return;
    }
    dlog("TR curr interval is ", this.currInterval);
    if (this.currInterval > this.refreshPeriod ) {
        if (!this.aborted) { xhr.abort(); this.aborted = true; }
        // Cannot call doHttpAction using xhr if xhr is not aborted.
        // Otherwise recursive call stack overflow occurs.
        if (this.aborted) {
            httpStatus = this.doHttpAction(xhr, http_method, url, reqparms,
                    "test-wait");
            if (httpStatus > 399) {
                errFound = true;
                if (this.logurl.length > 0) {
                    tmpxhr = new XMLHttpRequest();
                    tmpxhr.open("GET", this.logurl);
                    this.logsButRunning = tmpxhr.status != 200;
                    errFound = !this.logsButRunning;
                }
            }
        }
        if (!errFound) {
            this.currInterval = 0;
            if (!this.logsButRunning && this.logurl.length > 0) {
                tmpxhr = new XMLHttpRequest(); tmpxhr.open("GET", this.logurl);
                if (tmpxhr.status == 200 && tmpxhr.responseText.length > 0) {
                    // client pipe broken, but test still ran to completion
                    this.logsButRunning = true;
                }
            }
            this.aborted = false;
        }
        dlog("client pipe broken but have logs is", this.logsButRunning);
    }
});

TestPollHttpReq.method('sendReq', function(http_method, url,
        reqparms, elemid) {
    var xhr = new XMLHttpRequest(), started = false;

    this.doHttpAction(xhr, http_method, url, reqparms, "test-wait");

    var elem = null, trun = this, prevContents = "";
    var logUrl = "http://bbaero.freeddns.org/testlogs/";
    this.aborted = false;
    xhr.onreadystatechange = function(){
        if (elem !== undefined && elem != null) {
            curResponse = elem.innerHTML;
            if (curResponse.length > prevContents.length) {
                prevContents = curResponse;
            }
        }
        dlog(new Date().toLocaleString() + " xhr ready state is ",
               xhr.readyState);
        if (xhr.readyState == 2) {
            waitwarn = document.getElementById("wait-warn");
            waitwarn.style.display = "none";
        } else if (xhr.readyState == 3) {
            elem = document.getElementById(elemid);
            trun.updateContent(xhr, elem, prevContents);
            start_word_pos = xhr_resp.search(/: Starting /);
            if (trun.startTime.length < 1 && start_word_pos > 0) {
                trun.getStartTime(xhr_resp, start_word_pos);
            }
        } else if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                trun.updateContent(xhr, elem, prevContents);
            } else if (xhr.status > 399) {
                xhr.abort(); showXHRError("ERROR! CODE " + xhr.status);
            }
        }
        trun.stopPoll(elemid, "See results|** You", ": Finished ");
        if (trun.runDone) { xhr.abort()
        } else {
            trun.getUpdate(xhr, http_method, url, reqparms);
            if (trun.logsButRunning) {
                trun.runDone = true;
                elem.innerHTML += "\n<tr><td><br></td></tr><tr>\n";
                elem.innerHTML += "\t<td style='width: 0;'></td><td>See " +
                    "results <a href='" + trun.logurl + "'>here</a>";
            }
        }
    };
    if (!started) {
        this.intervalID = setInterval(function() {
            xhr.onreadystatechange(this)}, 1000);
        started = true;
    }
});

TestPollHttpReq.method('stopPoll', function(elemid, raw_stop_phrases,
        log_phrase) {
    this.currInterval++;
    raw_html = document.getElementById(elemid).innerHTML;
    cur_str = raw_html;
    if ((cur_str === undefined) || (cur_str == null)) { cur_str = ""; }
    stop_phrases = raw_stop_phrases.split("|");
    if ((stop_phrases === undefined) || stop_phrases == null) {
        stop_phrases = []; stop_phrases[0] = raw_stop_phrases;
    }
    stop_phr_len = stop_phrases.length;
    if (errFound === undefined || errFound == null) { errFound = false; }
    dlog("TestPoll - errFound is ", errFound);
    if (cur_str.indexOf(log_phrase) >= 0) {
        dlog("Trying to set log's index.html url");
        this.getRunLog(this.startTime);
    }
    for (cur_phr = 0; cur_phr < stop_phr_len; cur_phr++) {
        if (errFound || cur_str.indexOf(stop_phrases[cur_phr]) >= 0) {
            if (!errFound) {
                dlog("Clearing interval for phrase ", stop_phrases[cur_phr]);
            } else {
                dlog("set onreadystatechange to empty! Need this " +
                        "in case error stops clearInterval() from working!!");
                try { xhr.onreadystatechange= function() {};
                } catch (xhrGone) { dlog("xhr no longer defined"); }
                dlog("Trying to clear interval because of error!");
            }
            clearInterval(this.intervalID);
            waithdg = document.getElementById("test-wait");
            hdgtop = waithdg.style.top; hdgleft = waithdg.style.left;
            waitspinner = document.getElementById("test-wait-spinner");
            waitspinner.style.display = 'none';
            waithdg.style.display = 'none';
            donehdg = document.getElementById("test-done");
            donehdg.style.top = hdgtop; donehdg.style.left = hdgleft;
            donehdg.style.display = "inline-flex";
            // for browsers that do not support inline-flex, use
            // inline-block instead
            if (donehdg.style.display == 'none') {
                donehdg.style.display = "inline-block";
            }
            dlog(new Date().toLocaleString() + " should see done banner.");
            this.runDone = true;
            if (errFound) { return; }
        }
    }
});

function ReqPollHttpReq(status_id) {
    this.requpdater = new ReqUpdater(status_id); this.refreshPeriod = 15;
    this.currInterval = 0; this.inQueue = true; this.clientHadError = false;
}

ReqPollHttpReq.inherits(PollingHttpReq);

ReqPollHttpReq.method("updateContent", function(xhr, tblelem, statuselem) {
    xhr_resp = xhr.response;
    if (xhr_resp == null || xhr_resp == "null") { xhr_resp = ""; }
    dlog(new Date().toLocaleString() + " RQ XHR response: ", xhr_resp);
    msgs = xhr_resp.split("**");
    try {
        tblelem.innerHTML = msgs[0];
        status_msg = "";
        if (msgs[1] !== undefined) {
            status_msg = "**" + msgs.slice(1).join("<br>\n**");
        }
        statuselem.innerHTML = status_msg;
     } catch (noelem_e) { dlog("Already marked request as serviced"); }
});

ReqPollHttpReq.method("getUpdate", function(queue_pos, xhr, http_method,
        url, reqparms) {
    if (errFound === undefined || errFound == null) { errFound = false; }
    if (errFound) {
        dlog("ReqPoll stop sending getUpdates! Need this in case error " +
                "stops clearInterval() from working!!");
        return;
    }
    dlog("queue_pos is ", queue_pos, ", curr interval is ",
            this.currInterval);
    if (this.currInterval > this.refreshPeriod ) {
        if (queue_pos < 1) { queue_pos = 1; }
        if (!this.aborted) { xhr.abort(); this.aborted = true; }
        // Cannot call doHttpAction using xhr if xhr is not aborted.
        // Otherwise recursive call stack overflow occurs.
        if (this.aborted) {
            rem_req = "";
            if (this.clientHadError) { rem_req = "&remove=y"; }
            this.doHttpAction(xhr, http_method, url, reqparms +
                  "&pos=" + queue_pos + rem_req, "testrequest-container");
        }
        this.currInterval = 0; this.aborted = false;
    }
});

ReqPollHttpReq.method('sendReq', function(http_method, url, reqparms,
        elem_ids) {
    var xhr = new XMLHttpRequest(), started = false;
    var elemid = elem_ids.split("|");

    dlog("Initial TReq get");
    this.doHttpAction(xhr, http_method, url, reqparms,
            "testrequest-container");

    var tblelem = null, statuselem = null, msgs = null;
    var req = this, queue_pos = -1;
    realreqparms = reqparms + "&ts=" + (new Date().getTime());
    var fwdinfostr = 'CAN NOW BE SERVICED|' + chembalroot + 'runtest.php?' +
            realreqparms;

    this.aborted = false;
    xhr.onreadystatechange = function(){
        dlog(new Date().toLocaleString() + " RQxhr ready state is ",
                xhr.readyState);
        if (xhr.readyState == 0 || xhr.readyState == 1) {
            showQueueState('update');
        } else if (xhr.readyState == 2) {
            // not sure. Usually reach state 3 anyway, and state 3 sees elems
        } else if (xhr.readyState == 3) {
            showQueueState('wait');
            tblelem = document.getElementById(elemid[0]);
            statuselem = document.getElementById(elemid[1]);
            req.updateContent(xhr, tblelem, statuselem);
            queueposelem = document.getElementById("req-index");
            dlog("queueposelem", queueposelem);
            if (queueposelem !== undefined && queueposelem != null) {
                queue_pos = Number(queueposelem.innerHTML.substring(1));
                document.getElementById("qs-pos").innerHTML = queue_pos;
            }
        } else if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                req.updateContent(xhr, tblelem, statuselem);
            } else if (xhr.status > 399) {
                xhr.abort(); showXHRError("ERROR! CODE " + xhr.status);
            }
        }
        req.stopPoll(elemid[1], "** REQ", fwdinfostr, xhr);
        if (req.inQueue) {
            dlog("getUpdate TReq " + http_method);
            req.getUpdate(queue_pos, xhr, http_method, url, reqparms);
        }
    };
    if (!started) {
        this.intervalID = setInterval(function() {
            xhr.onreadystatechange(this)}, 1000);
        started = true;
    }
});

ReqPollHttpReq.method('stopPoll', function(elemid, raw_stop_phrases, fwd_str,
        xhr) {
    this.currInterval++;
    try {
         raw_html = document.getElementById(elemid).innerHTML;
    } catch (rawh_e) { raw_html = xhr.responseText; }
    cur_str = raw_html;
    if ((cur_str === undefined) || (cur_str == null)) { cur_str = ""; }
    stop_phrases = raw_stop_phrases.split("|");
    if ((stop_phrases === undefined) || stop_phrases == null) {
        stop_phrases = []; stop_phrases[0] = raw_stop_phrases;
    }
    if (errFound === undefined || errFound == null) { errFound = false; }
    dlog("ReqPoll - errFound is ", errFound);
    this.inQueue = !errFound;
    for (cur_phr = 0; cur_phr < stop_phrases.length; cur_phr++) {
        if (errFound || cur_str.indexOf(stop_phrases[cur_phr]) >= 0) {
            if (!errFound) {
                dlog("Clearing interval for phrase ", stop_phrases[cur_phr]);
            } else {
                dlog("set onreadystatechange to empty! Need this " +
                        "in case error stops clearInterval() from working!!");
                try { xhr.onreadystatechange= function() {};
                } catch (xhrGone) { dlog("xhr no longer defined"); }
                dlog("Trying to clear interval because of error!");
            }
            clearInterval(this.intervalID);
            fwdinfo = fwd_str.split("|");
            if (cur_str.indexOf(fwdinfo[0]) >= 0) {
                this.inQueue = false;
                showQueueState('go');
                xhrLoadPage(fwdinfo[1]);
            } else { this.clientHadError = true; showQueueState('err'); }
            if (errFound) { return; }
        }
    }
    this.requpdater.updateElapsed();
});

function ReqUpdater(stat_id) {
    this.status_id = stat_id; this.enq_start = new Date().getTime();
}

ReqUpdater.method('updateElapsed', function() {
    elapsed_elem = document.getElementById("queue-elapsed");
    if (elapsed_elem  === undefined || elapsed_elem == null) { return; }
    raw_html = document.getElementById(this.status_id).innerHTML;
    raw_elapsed = (new Date().getTime()) - this.enq_start;
    elapsed = Number.parseInt(raw_elapsed / 1000);
    if ((raw_elapsed % 1000) > 499) { elapsed++; }
    el_min = Number.parseInt(elapsed / 60);
    el_sec = elapsed % 60;
    elapsed_min = el_min + "";
    if (elapsed_min.length < 2) { elapsed_min = "0" + elapsed_min; }
    elapsed_sec = el_sec + "";
    if (elapsed_sec.length < 2) { elapsed_sec = "0" + elapsed_sec; }
    elapsed_str = "Time in queue: " + elapsed_min + ":" + elapsed_sec;
    document.getElementById("queue-elapsed").innerHTML = elapsed_str;
});

function getTestRequestStatus(tbl_id, status_id, runpct, failpct) {
    window.onerror = winErrorHandler;
    tblstat_id = tbl_id + "|" + status_id;
    url = "/chemtestpage/TRRequest";
    parms = "runpct=" + runpct + "&failpct=" + failpct;
    //rpxhr = Object.create(ReqPollHttpReq.prototype);
    rpxhr = new ReqPollHttpReq(status_id);
    rpxhr.sendReq("get", url, parms, tblstat_id);
}

function getAsyncTestStatus(tbl_id, runpct, failpct) {
    window.onerror = winErrorHandler;
    url = "/chemtestpage/TestRunner";
    parms = "runpct=" + runpct + "&failpct=" + failpct;
    //tpxhr = Object.create(TestPollHttpReq.prototype);
    tpxhr = new TestPollHttpReq();
    tpxhr.sendReq("post", url, parms, tbl_id);
}

// custom back/next button handling to prevent unintended access to servlets
// seems too hard/impossible
// - alternative: use XHR to load new page, then set title and body of current
//   page to new page's values. History remains unchanged. See xhrLoadPage()

