<?php 
	$page_title = "bbaero - Run chem balancer test";

	include $_SERVER['DOCUMENT_ROOT'].'/php/html-start-tmpl.php';

	include $_SERVER['DOCUMENT_ROOT'].'/php/nav-tmpl.php';

	$heading = 'Running chem balancer test suite';
	$lhs_heading = '';
	$rhs_heading = '';
	$lhs_html = <<<'EOD'
					<button id="teststart" onclick="showWaitAndTest();">Start testing</button>
					<div id='testwait' style='display: none;'><h3>Waiting for test servlet to finish execution...</h3>
						<p>
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						</p>
					</div>
EOD;
	$rhs_html = <<<'EOD'


EOD;

	$bottom_html = <<<'EOD'

EOD;

	include $_SERVER['DOCUMENT_ROOT'].'/php/main-tmpl.php';
	
	include $_SERVER['DOCUMENT_ROOT'].'/php/footer-tmpl.php'; 

	echo<<<'EJS'
	<!-- custom test execution script -->
	<script type="text/javascript">
		function showWaitAndTest() {
			document.getElementById("testwait").style.display = 'block';
			window.open ('https://bbaero.freeddns.org/chemtestpage/TestRunner?suite_xml=testng-default.xml','_self',false);
		}
	</script>
	
EJS;
	include $_SERVER['DOCUMENT_ROOT'].'/php/html-end-tmpl.php';
