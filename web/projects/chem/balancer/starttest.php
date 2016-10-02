<?php
	$page_title = "bbaero - Start chem balancer test";

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-start-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/nav-tmpl.php';

	$heading = 'Start chem balancer test suite';
	$lhs_heading = '';
	$rhs_heading = '';

	$lhs_html = <<<'EOD'

EOD;

	$rhs_html = <<<'EOD'

EOD;

	$bottom_html = <<<'EOD'

				<div class="formdiv">
					<form id="testform" name="testform" class="col-sm-2 col-md-2 col-lg-2">
					<div class='tf_hdr tf_gb_hdr'>Percent of tests to run</div>
					<input id="run_pct" name="runpct" style="display: none;">
					<div id="runbox" class="grpbox">
						<label><input type="radio" name="run_option" value="run_50" onclick="showIDHideOthers(getSelGBText('run_option'), 'runbox', '.gb_run_text')" checked><span>50% run</span></label>
						<label><input type="radio" name="run_option" value="run_25" onclick="showIDHideOthers(getSelGBText('run_option'), 'runbox', '.gb_run_text')"><span>25% run</span></label>
						<label><input type="radio" id="run_all" name="run_option" value="run_all" onclick="showIDHideOthers(getSelGBText('run_option'), 'runbox', '.gb_run_text')"><span>All</span></label>
						<label id='cust_runpct_label'><input type="radio" name="run_option" value="run_cust" onclick="showIDHideOthers(getSelGBText('run_option'), 'runbox', '.gb_run_text')"><span>given % of tests to run</span><input id="cust_runpct" inputmode='numeric' type="text" minlength=1 maxlength=2 value='75' onblur='document.getElementById("cust_runpct_label").click();'>%</label>
					</div>
					<div class='tf_hdr tf_gb_hdr'>Expected test results</div>
					<input id="fail_pct" name="failpct" style="display: none;">
					<div id="failbox" class="grpbox">
						<label><input type="radio" id="exp_pass" name="fail_option" value="exp_pass" onclick="showIDHideOthers(getSelGBText('fail_option'), 'failbox', '.gb_exp_text')" checked><span>All pass</span></label>
						<label><input type="radio" name="fail_option" value="exp_fail_20" onclick="showIDHideOthers(getSelGBText('fail_option'), 'failbox', '.gb_exp_text')"><span>20% of tests fail</span></label>
						<label><input type="radio" name="fail_option" value="exp_fail_40" onclick="showIDHideOthers(getSelGBText('fail_option'), 'failbox', '.gb_exp_text')"><span>40% of tests fail</span></label>
						<label><input type="radio" name="fail_option" value="exp_fail_60" onclick="showIDHideOthers(getSelGBText('fail_option'), 'failbox', '.gb_exp_text')"><span>60% of tests fail</span></label>
						<label id='cust_pct_label'><input type="radio" name="fail_option" value="exp_fail_cust" onclick="showIDHideOthers(getSelGBText('fail_option'), 'failbox', '.gb_exp_text')"><span>given % of tests fail</span><input id="cust_failpct" name="pct" inputmode='numeric' type="text" minlength=1 maxlength=2 value='10' onblur='document.getElementById("cust_pct_label").click();'>%</label>
					</div>
						<!--<button id="teststart" form="testform" formaction="runtest.php" onclick="startTest();">Start testing</button>-->
						<button id="teststart" form="testform" type="button" onclick="startTest();">Start testing</button>
				</div>
				</form>
			</div>
		<div class="row">
			<div class='tf_hdr row'>Details</div>
			<div class="gb_run_text col-xs-12" id="gbt_run_50">
				Run a random 50% of the total tests. Completes in about 2-3 minutes.
			</div>
			<div class="gb_run_text col-xs-12" id="gbt_run_25" style="display: none;">
				Run a random 25% of the total tests. Completes in about 1-2 minutes.
			</div>
			<div class="gb_run_text col-xs-12" id="gbt_run_all" style="display: none;">
				Run all tests. Completes in about 5 minutes.
			</div>
			<div class="gb_run_text col-xs-12" id="gbt_run_cust" style="display: none;">
				Run a random user-specified percent of the total tests. Time to complete, somewhere between 1-5 minutes. 
			</div>
		</div>
		<div class="row"><br></div>
		<div class="row">
			<div class="gb_exp_text col-xs-12" id="gbt_pass">
				Expect that all tests will pass. This is the normal way tests should run in production.
			</div>
			<div class="gb_exp_text col-xs-12" id="gbt_fail_20" style="display: none;">
				Expect that a random 20 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb_exp_text col-xs-12" id="gbt_fail_40" style="display: none;">
				Expect that a random 40 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb_exp_text col-xs-12" id="gbt_fail_60" style="display: none;">
				Expect that a random 60 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb_exp_text col-xs-12" id="gbt_fail_cust" style="display: none;">
				Expect that a random user-specified percent of the tests will fail, while the
				other tests pass. This is to demonstrate the test's failure handling.
			</div>
		</div>

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';
