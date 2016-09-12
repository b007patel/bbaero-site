<?php
	$page_title = "bbaero - Run chem balancer test";

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-start-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/nav-tmpl.php';

	$heading = 'Running chem balancer test suite';
	$lhs_heading = '';
	$rhs_heading = '';

	$lhs_html = <<<'EOD'
					<div id="testform_lhs_hdr" class='tf_hdr'>Expected test results</div>
					<form id="testform" name="testform">
					<input id="fail_pct" name="pct" style="display: none;">
					<div class="grpbox">
						<label><input type="radio" name="suite_type" id="exp_pass" value="exp_pass" onclick="showIDHideOthers(getCurrGBDetailText(), 'div#rhs div.body-text', '.gb_exp_text')" checked><span>All pass</span></label>
						<label><input type="radio" name="suite_type" value="exp_fail_20" onclick="showIDHideOthers(getCurrGBDetailText(), 'div#rhs div.body-text', '.gb_exp_text')"><span>20% of tests fail</span></label>
						<label><input type="radio" name="suite_type" value="exp_fail_40" onclick="showIDHideOthers(getCurrGBDetailText(), 'div#rhs div.body-text', '.gb_exp_text')"><span>40% of tests fail</span></label>
						<label><input type="radio" name="suite_type" value="exp_fail_60" onclick="showIDHideOthers(getCurrGBDetailText(), 'div#rhs div.body-text', '.gb_exp_text')"><span>60% of tests fail</span></label>
						<label id='cust_pct_label'><input type="radio" name="suite_type" value="exp_fail_cust" onclick="showIDHideOthers(getCurrGBDetailText(), 'div#rhs div.body-text', '.gb_exp_text')"><span>given % of tests fail</span><input id="cust_pct" name="pct" inputmode='numeric' type="text" minlength=1 maxlength=2 value='10' onblur='document.getElementById("cust_pct_label").click();'>%</label>
					</div>
						<button id="teststart" form="testform" formaction="https://bbaero.freeddns.org/chemtestpage/TestRunner" onclick="showWaitAndTest();">Start testing</button>
					</form>
					<div id='testwait' style='display: none;'><h3>Waiting for test servlet to finish execution...</h3>
						<p>
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						</p>
					</div>

EOD;

	$rhs_html = <<<'EOD'
			<div id='testform_rhs_hdr' class='tf_hdr'>Details</div>
			<div class="gb_exp_text" id="gbt_pass">
				Expect that all tests will pass. This is the normal way tests should run in production.
			</div>
			<div class="gb_exp_text" id="gbt_fail_20" style="display: none;">
				Expect that a random 20 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb_exp_text" id="gbt_fail_40" style="display: none;">
				Expect that a random 40 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb_exp_text" id="gbt_fail_60" style="display: none;">
				Expect that a random 60 percent of the tests will fail, while the other tests
				pass. This is to demonstrate the test's failure handling.
			</div>
			<div class="gb_exp_text" id="gbt_fail_cust" style="display: none;">
				Expect that a random user-specified percent of the tests will fail, while the
				other tests pass. This is to demonstrate the test's failure handling.
			</div>

EOD;

	$bottom_html = <<<'EOD'

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';
