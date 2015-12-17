<?php 
	$page_title = "Bubbly Bubbly Aero - Error";

	include 'php/html-start-tmpl.php';

	include 'php/nav-tmpl.php';

	include 'php/error-lib.php';

	$errvals = get_error_vals();
	$heading = "<span class='bbaero_error'>HTTP Error ";
	$heading .= $errvals['code'];
	$heading .= " - ";
	$heading .= $errvals['reason'];
	$heading .= "</span>";

	$lhs_heading = '';
	$rhs_heading = '';
	$lhs_html = <<<'EOD'


EOD;

	$rhs_html = <<<'EOD'


EOD;

	
	//if($_SERVER['REMOTE_ADDR']=='youripaddress')askapache_global_debug();

	$bottom_html = <<<'EOD'
	
						<p>

EOD;

	$bottom_html .= "\t\t\t\t\t\t".$errvals['message'];

	$bottom_html .= <<<'EOD'
	
						</p>
						
						<p>
						Please try reloading the page. If the error still 
						occurs, notify the site administrator.
						</p>


EOD;

	include 'php/main-tmpl.php';
	
	include 'php/footer-tmpl.php'; 
	
	include 'php/html-end-tmpl.php';
