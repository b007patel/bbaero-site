<?php 
	$GLOBALS['have_footer'] = false;
	$GLOBALS['have_endhtml'] = false;
	$page_title = "bbaero, Projects - Chem Reaction Balancer";

	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';

	$heading = 'Chemical Reaction Balancer';
	$lhs_heading = 'Background';
	$rhs_heading = 'Approach';
	$lhs_html = <<<'EOD'
						<p>
						I'm a volunteer math and science tutor with <a href="https://www.pathwaystoeducation.ca/kitchener">Pathways to Education</a>.
						I find many students struggle to balance chemical reactions. I looked 
						online for balancing tools. To my chagrin none of these tools listed the steps 
						taken to balance a given reaction. Since I wanted to make a website using AJAX anyway, 
						and test it with Selenium, I figured I would try to make a balancer that showed its work.
						</p>

						<p>
						I assumed that <ul>
			<li>because this project will be used in tutoring, I designed it "large-screen 
			first", versus the standard "mobile first" technique used in designing most of the 
			bbaero site. 
						<li>only simple reactions are to be balanced.</li>
						<ul><li>Half-cell reactions and hard-to-balance reactions will fail to balance, 
						even though they may be able to be balanced</li>
						<li>It is a learning opportunity for the student when a reaction is deemed 
						"impossible to balance." Follow-up questions include</li>
						<li>Is this reaction truly impossible to balance?</li>
						<li>If not, how do we balance it?</li>
						<li>What should the computer have done differently?</li>
						<li>and others</li></ul>
						<li>no ions (i.e., particles with non-zero net charges) can be given as 
						reactants or products</li>
						<li>hydrated salts (i.e., with "xH2O" molecules trapped in their crystal 
						lattice) are forbidden</li>
						<li>compounds given are valid. Only elements are checked.</li>
						<ul><li>for example, both H2O and H5O are accepted by the balancer, even
						though H5O does not exist</li></ul></ul> 
						</p>

EOD;

	$rhs_html = <<<'EOD'
						<p>
						Client side Javascript does some of the input validation. For example, 
						scripts check whether each compound is composed of valid elements. Once client
						validation complete, a JSON object is sent to PHP scripts. 
						It is these server-side scripts that performs the actual balancing, or outputs 
						client-detected errors in the JSON object.
						</p>

						<p>
						I have not bothered to ensure my Javascript is Internet Explorer compatible. 
						I may add that backward compatibility later, if needed. For the most part, 
						the balancer should work with Microsoft's Edge browser. But as of Sept 7, 2016, 
						it has not been tested.
						</p>

						<p>
						I wanted to have the tests start from a web browser, and run in a headless 
						setup on the web server. Because I decided to use Java, I run the headless 
						tests via a servlet. Go to the <a href="runtest.php">run tests</a> page to start them.
						</p>

EOD;

	$bottom_html = <<<'EOD'
						<h3>Takeaways and Possible enhancements</h3>
						<p>
						Some simple reactions, like 'H2O2 = H2O + O2', really should be balanced by 
						the balancer. Currently it fails because it took too many steps (i.e., gets 
						caught in an infinite balancing loop). Perhaps I will fix some of the balancing 
						logic.
						</p>

						<p>
						What I definitely want to go going forward, though, is add animation to the
						chemical reaction balancer. Why? Students have such short attention spans, so
						any bells and whistles to attract their attention are always welcome. Also, 
						animating the results of each step should help students understand what is 
						happening in a given step. For example, if the step says 'multiply coefficients 
						by 4 to make F counts match', highlighting the compounds with fluorine (F) 
						that have changing coefficients focuses attention on one particular step. 
						From what I have read testing animation cannot be automated well, if at all. 
						However, I think my current <a href="testing.php">testing</a> gear will 
						be helpful to confirm that the needed CSS classes and/or IDs that indicate 
						which tags to animate are where they should be.
						</p> 

						<h3>Source Code</h3>
						<p>
						Source code for the chemistry reaction balancer is at <a href="https://github.com/b007patel/tutor-prez">tutor-prez</a> in my GitHub
						repository. The web/php, web/chem and web/js directories have most of the 
						core balancer functionality's code.
						</p>

EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	$GLOBALS['have_footer'] = true;
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
	$GLOBALS['have_endhtml'] = true;
