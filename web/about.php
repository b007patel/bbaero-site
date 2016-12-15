<?php
	$GLOBALS['have_footer'] = false;
	$GLOBALS['have_endhtml'] = false;
	$page_title = "Bubbly Bubbly Aero - The Site Explained";
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';
	$heading = 'About this site';
	$lhs_heading = 'Why make this website?';
	$rhs_heading = 'How has this website been made?';
	$lhs_html = <<<'EOD'
						<p>
						After many years doing software QA for the same company, I needed a bit of 
						a break. However, I have found it difficult to find another IT job. I 
						believe part of the reason is that potential employers wonder what I have 
						done IT-wise while not working. You can find out more about me on the 
						<a href="bharat.php">About Bharat</a> page.
						</p>

						<p>
						This site showcases most of my IT knowledge via various example <a href="projects/index.php">projects</a>.
						I use an Amazon Web Services (AWS) Ubuntu instance to host the website and any
						associated backend servers (e.g., databases, application servers).
						</p>

						<p>
						Whenever possible, I will try to justify my design solutions. All the 
						source for the examples is viewable in my 
						<a href="https://github.com/b007patel/">GitHub repository</a>.
						</p>

						<p>
						Thoughts? Comments? Feel free to make them <a href="feedback.php">here.</a>
						</p>

EOD;

	$rhs_html = <<<'EOD'
						<p>
						After taking an introductory web development course I built this 
						website. The source is on 
						<a href="https://github.com/b007patel/bbaero-site">GitHub</a>.
						</p> 

						<p>
						This site demonstrates my HTML, CSS, and JavaScript skills. 
						This site uses the Bootstrap framework, and it uses PHP to reuse HTML.
						</p>

EOD;

	$bottom_html = <<<'EOD'
					<h3 id="technologies">Technologies used to build this site</h3>
					<ul id="techlist">

EOD;
	
	foreach ( $tech_imgs as $currILI ) {
		$ili = new ImageLI( 6, "footer" );
		$ili->showLabel( true );
		$ili->setLabel( $currILI["label"] );
		$ili->setLink( $currILI["link"] );
		$ili->setCssID( $currILI["cssID"] );
		$ili->setImageLoc( $currILI["imgloc"] );
		$bottom_html .= $ili->listItemMarkup();
	}
	
	$bottom_html .= <<<'EOD'

					</ul>

EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	$GLOBALS['have_footer'] = true;
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
	$GLOBALS['have_endhtml'] = true;
