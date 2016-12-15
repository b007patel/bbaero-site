<?php
	$GLOBALS['have_footer'] = false;
	$GLOBALS['have_endhtml'] = false;
	$page_title = "bbaero - Start chem balancer test";

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-start-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/nav-tmpl.php';

	$nl = chr(10);
	$t = chr(9);

	$heading = 'Start chem balancer test suite';
	$lhs_heading = '';
	$rhs_heading = '';

	$script_call = $t.$t.$t.'window.onload=showIDHideOthers(';
	$script_call .= 'getSelGBText("runoption"), "runbox", ';
	$script_call .= '".gb-run-text");'.$nl;
	$custom_scripts = '/js/chem-balancer.js';

	$lhs_html = <<<'EOD'

EOD;

	$rhs_html = <<<'EOD'

EOD;

	$bottom_html = <<<'EOD'

				<div class="formdiv">
					<form id="testform" name="testform" class="col-sm-2 col-md-2 col-lg-2">
					<div class='tf-hdr tf-gb-hdr'>Percent of tests to run</div>
					<input id="run-pct" name="runpct" style="display: none;">
					<div id="runbox" class="grpbox">
						<label><input type="radio" name="runoption" value="run_25" onclick="showIDHideOthers(getSelGBText('runoption'), 'runbox', '.gb-run-text')" checked><span>25% run</span></label>
						<label><input type="radio" name="runoption" value="run_50" onclick="showIDHideOthers(getSelGBText('runoption'), 'runbox', '.gb-run-text')"><span>50% run</span></label>
						<label><input type="radio" id="run-all" name="runoption" value="run_all" onclick="showIDHideOthers(getSelGBText('runoption'), 'runbox', '.gb-run-text')"><span>All tests run</span></label>
						<label id='cust-runpct-label'><input type="radio" name="runoption" value="run_cust" onclick="showIDHideOthers(getSelGBText('runoption'), 'runbox', '.gb-run-text')"><input id="cust-runpct" inputmode='numeric' type="text" minlength=1 maxlength=2 value='75' onblur='document.getElementById("cust-runpct-label").click();'>%<span> run</span></label>
					</div>
					<div class='tf-hdr tf-gb-hdr'>Expected test results</div>
					<input id="fail-pct" name="failpct" style="display: none;">
					<div id="failbox" class="grpbox">
						<label><input type="radio" id="exp-pass" name="failoption" value="exp_pass" onclick="showIDHideOthers(getSelGBText('failoption'), 'failbox', '.gb-exp-text')" checked><span>All pass</span></label>
						<label><input type="radio" name="failoption" value="exp_fail_20" onclick="showIDHideOthers(getSelGBText('failoption'), 'failbox', '.gb-exp-text')"><span>20% of tests fail</span></label>
						<label><input type="radio" name="failoption" value="exp_fail_40" onclick="showIDHideOthers(getSelGBText('failoption'), 'failbox', '.gb-exp-text')"><span>40% of tests fail</span></label>
						<label><input type="radio" name="failoption" value="exp_fail_60" onclick="showIDHideOthers(getSelGBText('failoption'), 'failbox', '.gb-exp-text')"><span>60% of tests fail</span></label>
						<label id='cust-pct-label'><input type="radio" name="failoption" value="exp_fail_cust" onclick="showIDHideOthers(getSelGBText('failoption'), 'failbox', '.gb-exp-text')"><input id="cust-failpct" name="pct" inputmode='numeric' type="text" minlength=1 maxlength=2 value='10' onblur='document.getElementById("cust-pct-label").click();'>%<span> of tests fail</span></label>
					</div>
						<button id="teststart" form="testform" type="button" onclick="enqueueTest();">Start testing</button>
				</div>
				</form>
			</div>
		<div class="row">
			<div class='tf-hdr row'>Details</div>
			<div class="gb-run-text col-xs-12" id="gbt-run-50" style="display: none;">
				Run a random 50% of the total tests. Completes in about 2-3 minutes.
			</div>
			<div class="gb-run-text col-xs-12" id="gbt-run-25" style="display: none;">
				Run a random 25% of the total tests. Completes in about 1-2 minutes.
			</div>
			<div class="gb-run-text col-xs-12" id="gbt-run-all" style="display: none;">
				Run all tests. Completes in about 5 minutes.
			</div>
			<div class="gb-run-text col-xs-12" id="gbt-run-cust" style="display: none;">
				Run a random user-specified percent of the total tests. Time to complete, somewhere between 1-5 minutes. 
			</div>
		</div>
		<div class="row"><br></div>
		<div class="row">
			<div class="gb-exp-text col-xs-12" id="gbt-pass">
				Expect that all tests will pass. This is the normal way tests should run in production.
			</div>
			<div class="gb-exp-text col-xs-12" id="gbt-fail-20" style="display: none;">
				Expect that a random 20 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb-exp-text col-xs-12" id="gbt-fail-40" style="display: none;">
				Expect that a random 40 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb-exp-text col-xs-12" id="gbt-fail-60" style="display: none;">
				Expect that a random 60 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb-exp-text col-xs-12" id="gbt-fail-cust" style="display: none;">
				Expect that a random user-specified percent of the tests will fail, while the
				other tests pass. This is to demonstrate the test's failure handling.
			</div>
		</div>

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php';
	$GLOBALS['have_footer'] = true;

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';
	$GLOBALS['have_endhtml'] = true;
