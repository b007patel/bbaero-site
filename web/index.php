<?php 
	$page_title = "Bubbly Bubbly Aero - Home";

	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';

	$heading = 'Welcome to bbaero!';
	$lhs_heading = 'Bharat Patel\'s website';
	$rhs_heading = '';
	$lhs_html = <<<'EOD'
						<p>
						Thanks for visiting! This site is a platform for me (Bharat, pronounced <span 
						class="phonetic">bear-IT</span>) to showcase my tech skills.
						</p>

EOD;
	$rhs_html = <<<'EOD'


EOD;

	$bottom_html = <<<'EOD'
					<p>Please do not hesitate to give me <a href="feedback.php">feedback</a> about the site.</p>

EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
