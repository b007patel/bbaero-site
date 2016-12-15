<?php
	$GLOBALS['have_footer'] = false;
	$GLOBALS['have_endhtml'] = false;
	$page_title = "bbaero - Current test status";

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-start-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/nav-tmpl.php';

	$nl = chr(10);
	$t = chr(9);

	$heading = 'Running chem balancer test suite';
	$lhs_heading = '';
	$rhs_heading = '';

	$lhs_html = <<<'EOD'
EOD;

	$rhs_html = <<<'EOD'
EOD;

	$custom_scripts = '/js/chem-balancer.js';
	$script_call = $t.$t.$t.'getAsyncTestStatus("testres-tbl", ';
	//$script_call = $t.$t.$t.'getSyncTestStatus("testres-tbl", ';
        $rpct = ""; $fpct = "";
        if (isset($_POST['runpct'])) {
            $rpct = $_POST['runpct'];
        }
        if (isset($_POST['failpct'])) {
            $fpct = $_POST['failpct'];
        }
        if (trim($rpct) == "") {
            $rpct = "-N/A-";
            if (isset($_GET['runpct'])) {
                $rpct = $_GET['runpct'];
                if (trim($rpct) == "") {
                    $rpct = "-N/A-";
                }
            }
        }
        if (trim($fpct) == "") {
            $fpct = "-N/A-";
            if (isset($_GET['failpct'])) {
                $fpct = $_GET['failpct'];
                if (trim($fpct) == "") {
                    $fpct = "-N/A-";
                }
            }
        }
	$script_call .= '"'.$rpct.'", "'.$fpct.'");'.$nl;

	$bottom_html = <<<'EOD'

		<table id="test-wait" class="testres-hdr">
			<tr><td><span id="test-wait-spinner" style="display: inline-flex;">
				Waiting for test servlet to finish execution...<i class="fa fa-spinner fa-pulse status-icon fa-fw"></i>
			</span></td></tr>
			<tr id="wait-warn"><td><h4>May take 10 sec - 15 sec for servlet output to appear</h4></td></tr>
		</table>
		<span id='test-done' class="testres-hdr" style="display: none;">
			Done testing
		</span>
		<div id="testres-container">
		    <table id="testres-tbl">
		    </table>
		</div>

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php';
	$GLOBALS['have_footer'] = true;

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';
	$GLOBALS['have_endhtml'] = true;

