<?php
	$GLOBALS['have_footer'] = false;
	$GLOBALS['have_endhtml'] = false;
	$page_title = "bbaero - Test request status";

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-start-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/nav-tmpl.php';

	$nl = chr(10);
	$t = chr(9);

	$heading = 'Balancer Test Run Request';
	$lhs_heading = '';
	$rhs_heading = '';

	$lhs_html = <<<'EOD'
EOD;

	$rhs_html = <<<'EOD'
EOD;

	$custom_scripts = '/js/chem-balancer.js';
	$script_call = $t.$t.$t.'getTestRequestStatus("testrequest-tbl", ';
	$script_call .= '"testrequest-status", "'.$_GET['runpct'].'", ';
	$script_call .= '"'.$_GET['failpct'].'");'.$nl;

	$bottom_html = <<<'EOD'

		<div id="testrequest-summary"><h4>Request status</h4>
		<table id='queue-state'>
			<tr class="tbl-header"><td class="autowidth">Index</td><td class="blanktd"></td><td>State</td></tr>
			<tr><td id="qs-pos" class="autowidth qs-text">#</td>
				<td class='qs-update qs-icon tbl-cell-show'><i class="fa fa-spinner fa-pulse status-icon fa-fw"></i></td>
				<td class='qs-update qs-text tbl-cell-show'>Updating queue status</td>
				<td class='qs-wait qs-icon hidden'><i class="fa fa-pause-circle status-icon"></i></td>
				<td class='qs-wait qs-text hidden'>Waiting in queue</td>
				<td class='qs-go qs-icon hidden'><i class="fa fa-check-square status-icon"></i></td>
				<td class='qs-go qs-text hidden'>Servicing request</td>
				<td class='qs-err qs-icon hidden'><i class="fa fa-times-circle status-icon"></i></td>
				<td class='qs-err qs-text hidden'>ERROR!!!</td>
			</tr>
		</table></div>
		<div id="testrequest-container">
		    <table id="testrequest-tbl">
		    </table>
		</div>
		<div id="testrequest-status">
			<span id='queue-elapsed'></span><br>
		</div>

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php';
	$GLOBALS['have_footer'] = true;

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';
	$GLOBALS['have_endhtml'] = true;

