<?php include 'php/html-start-tmpl.php';

	include 'php/nav-tmpl.php';

	$heading = 'Welcome to bbaero!';
	$lhs_heading = 'Bharat Patel\'s website';
	$rhs_heading = '';
	$lhs_html = <<<'EOD'
				<p>Thanks for visiting! This site is a platform for me (Bharat, pronounced <span 
				class="phonetic">bear-IT</span>) to showcase my tech skills.</p>

EOD;
	$rhs_html = <<<'EOD'


EOD;

	$bottom_html = <<<'EOD'
				<p>Please do not hesitate to give me <a href="feedback.html">feedback</a> about the 
				site.</p>

EOD;

	include 'php/main-tmpl.php';
	
	include 'php/footer-tmpl.php'; 
	
	include 'php/html-end-tmpl.php';