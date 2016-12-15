<?php 
	$page_title = "Bubbly Bubbly Aero - Error";

	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/error-lib.php';

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

	$disp_err_msg = $errvals['message'];
	if (isset($_GET['euri'])) {
                $sl1 = strpos($disp_err_msg, " /");
                $sl2 = strpos($disp_err_msg, "/ ");
		$disp_err_msg = substr_replace($disp_err_msg, $_GET['euri'],
			$sl1 + 1, $sl2 - $sl1);
	}
	$bottom_html .= "\t\t\t\t\t\t".$disp_err_msg;

	$bottom_html .= <<<'EOD'
	
						</p>
						
						<p>
						Please try reloading the page. If the error still 
						occurs, notify the site administrator.
						</p>


EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	/*include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	$GLOBALS['have_footer'] = true;
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
	$GLOBALS['have_endhtml'] = true;*/
