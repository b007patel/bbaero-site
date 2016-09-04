<?php
	$page_title = "Example projects";
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';
	$heading = 'Projects on the go';
	$lhs_heading = 'Project types';
	$rhs_heading = 'My Projects';
	$lhs_html = <<<'EOD'
						<p>
						I'm hoping to accomplish different goals with these example projects. They are <ul>
						<li>learn new technologies</li>
						<li>prove that I know what technologies I say I know</li>
						<li>use certain projects to help me and students I volunteer to tutor via <a href="https://www.pathwaystoeducation.ca/kitchener">Pathways to Education</a></li></ul>
                                                I believe in the saying, "Use it or lose it," especially when it comes to my intellect.
						Working on this page's projects helps me stay sharp by learning new technologies.
						</p>

EOD;

	$rhs_html = <<<'EOD'
						<p>
						The projects on which I am currently working are
						<h4>This website (<a href="metaproj/index.php">bbaero-site</a>)</h4><ul>
						<li>technologies used: CSS, JavaScript, PHP</li>
						<li>source: <a href="https://github.com/b007patel/bbaero-site">bbaero-site on GitHub</a></li></ul><br>
						<h4>Tutor aids</h4><ul>
						<li><a href="projects/chem/index.php">Chemistry</a></li><ul>
						<li><a href="/tutor-prez/web/chem/balance.php">reaction balancer</a> (<a href="chem/balancer/index.php">balance.php in tutor-prez</a>)</li><ul>
						<li>technologies used: JavaScript, PHP, JSON to transmit objects from JavaScript to PHP</li>
						<li><a href="projects/chem/balancer/testing.php">testing</a>: done using Selenium and TestNG</li>
						<li>source: <a href="https://github.com/b007patel/tutor-prez">tutor-prez on GitHub</a></li></ul>
						</p> 

EOD;

	$bottom_html = <<<'EOD'
EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
