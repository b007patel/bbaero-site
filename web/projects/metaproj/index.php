<?php 
	$page_title = "bbaero-site - More Details";

	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';

	$heading = 'Design of this site (bbaero-site)';
	$lhs_heading = 'Considerations';
	$rhs_heading = 'Why not some other tools?';
	$lhs_html = <<<'EOD'
						<p>
						Because I took an introductory web design course, I decided to use CSS and 
						JavaScript within the Bootstrap framework. That's what we learned. Our instructor
						mentioned PHP is good to use for reusing HTML snippets. In this site you see that
						with the navigation toolbar and the bottom technology image banner. However, the 
						bottom banner is only visible on large screened devices. Here large is whatever
						screen dimensions Bootstrap deems as large.
						</p>

						<p>
						Other possible tools to design this site include<ul>
						<li>Servlets and Java Server Pages (JSPs) served by a servlet container, like Apache Tomcat</li>
						<li>Python using a framework like Django</li>
						<li>Perl using a framework, althought I don't know of any offhand.</li>
						<li>Ruby on Rails</li></ul>
						Of course this list is nowhere near being exhaustive. And the tools listed above
						would probably use CSS and Bootstrap for cleaning up their output's display formats.
						</p>

EOD;

	$rhs_html = <<<'EOD'
						<p>
						Servlets and JSPs seemed too complex for what I needed. They are used throughout
						the web, but I didn't need most of the servlet/JSP functionality. Templating HTML
						wouldn't be as straightforward as it is in a language designed to generate documents
						from templates such as PHP. Also, servlets need to be compiled, as compared to
						PHP scripts and the scripts for the other technologies above.
						</p>
						<p>
						Like servlets and JSPs, technologies such as Python, Perl and Ruby aren't as well
						suited to template-based page generation as PHP is. Having had experience with
						Python and Perl before taking my intro to web developmemt, I did consider them
						before settling on PHP. But PHP is great for generating documents based on
						templates. Simply include the template php files via a <code>&lt;?php include ...?&gt;</code>
						directive in the outer PHP file, and the included PHP script is reused in a snap!
						</p>
						<h3>Aren't there similar frameworks to Bootstrap?</h3>
						<p>
						I believe so, but since I never learned about them, I stick to using Bootstrap.
						</p>

EOD;

	$bottom_html =  '						<h3>It\'s well past 2009, and <a href="http://'.$_SERVER['SERVER_NAME'].'/feedback.php">feedback.php</a> doesn\'t use recaptcha</h3>'.chr(10);
	$bottom_html .= <<<'EOD'
						<p>
                        Recaptcha requires API tags based on your domain name, and I don't want my site to be 
                        searchable on Google just quite yet. So I opted for freecap.php, even though its author recommends recaptcha instead of it.
						</p>

						<h3>Testing</h3>
						<p>
						This site has not been formally tested (bad SQA specialist! LOL!). I have not
						designed formal tests because a lot of the site's contest is manual, except
						for the example projects. Because those display dynamic content, I will at 
						design test plans for them. Hopefully, as with the <a href="/tutor-prez/web/chem/balance.php">chem balancer</a>
						project, all of the example projects will have Selenium test scripts.
						</p> 

						<h3>Source Code</h3>
						<p>
						Source code for this web site is in the <a href="https://github.com/b007patel/bbaero-site">bbaero-site</a> GitHub
						repository. In case I deploy broad, site-wide backend servers (e.g., an RDBMS, 
						an application server), I will use the bbaero-backend repository for those server
						technologies' code.
						</p>

EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
