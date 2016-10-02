<?php
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

	$script_call = $t.$t.$t.'getAsyncTestStatus("testres_tbl", ';
	//$script_call = $t.$t.$t.'getSyncTestStatus("testres_tbl", ';
	$script_call .= '"'.$_GET['runpct'].'", "'.$_GET['failpct'].'");'.$nl;

	$bottom_html = <<<'EOD'

		<span id='testwait' style="display: inline-flex;">
			<h3>Waiting for test servlet to finish execution...</h3><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
		</span>
		<span id='testdone' style="display: none;">
			<h3>Done testing</h3>
		</span>
                <div id="testres_container">
                    <table id="testres_tbl">
                    </table>
                <div>

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';

