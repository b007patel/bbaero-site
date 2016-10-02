<?php 
	$page_title = "Testing - Chem Balancer";

	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';

	$heading = 'Testing of the Chemical Reaction Balancer';
	$toplink = <<<'ETL'
<h4>Note: to run headless tests on this web server go to the <a href="starttest.php">start tests</a> page to start them.<br>
<br>
Previous test runs' logs are <a href="/testlogs/?C=M;O=D">here</a></h4>

ETL;
	$lhs_heading = 'Considerations';
	$rhs_heading = 'Approach';
	$lhs_html = <<<'EOD'
						<p>
						Because of the number of test cases, I decided to use data driven testing 
						to test the <a href='index.php'>balancer</a>. Currently the test data is 
						in a MySQL database.
						</p>

						<p>
						To verify a given test case, the resulting PHP page is compared to selected 
						HTML code fragments in the test database. This method of verification should 
						remain relevant when animation is added to the balancer result page.
						</p>

						<p>
						Given these design choices, I had to choose tools to implement testing. 
						Because I knew I was using Selenium, I narrowed down my implementation languages 
						down to 3 choices. They were Python, Ruby and Java.
						</p>

						<p>
						I have familiarity with Python, but because of the global interpreter locking 
						(GIL) model it uses, concurrency is only possible by spawning separate processes. 
						For this small set of tests (about 26 tests) Python would have served well.
						However, I wanted to use a solution that could lend itself easily to test 
						partitioning on the same machine.
						</p>

						<p>
						I am not too familiar with Ruby, but from what I have read the M implementation
						of Ruby uses a GIL model like Python. There is the JRuby implementation of Ruby 
						that runs the Ruby interpreter in a JVM. So JRuby supports the Java threading model. 
						However, there is overhead in running Ruby on top of Java, which is what JRuby 
						essentially does.
						</p>
EOD;

	$rhs_html = <<<'EOD'
						<p>
						Because I wanted testing to scale upwards by partitioning tests to run 
						concurrently on the same machine, I decided to use Java. Also, Selenium seems 
						to update their Java support first. This is an important consideration because
						web browsers are updated so often, often making previous versions of their 
						corresponding drivers behave differently than before.
						</p>

						<p>
						Selenium coupled with TestNG provides a test framework that supports Grid 
						testing across multiple machines. One machine acts a hub to the other node 
						machines. I have not yet implemented a grid setup, but it seems fairly straight-
						forward to move from a non-Grid TestNG setup to a grid setup.
						</p>

						<p>
						I wanted to have the tests start from a web browser, and run in a headless 
						setup on the web server. Because I decided to use Java, I run the headless 
						tests via a servlet. Go to the <a href="starttest.php">start tests</a> page to start them.
						</p>

EOD;

	$bottom_html = <<<'EOD'
						<h3>Takeaways and Possible enhancements</h3>
						<p>
						While using a threaded test client seemed like a good idea in theory, threading 
						offers no practical benefit. This is because it is recommended to only run one 
						instance of a web driver on one machine at a time. If I knew this beforehand, I 
						probably would have used Python to implement testing. I would have used CGI for 
						the testing web page.
						</p>

						<p>
						Test reporting is admittedly lacking at the moment. Using custom TestNG listeners 
						to improve it is on my to-do list. Currently I am building an XmlSuite object 
						and an XmlTest object using the TestNG API, rather than using a static suite XML file.
						However, I am using a long, convoluted suite name to record the browser type and
						version, and the OS type and version. The log directory name is set to 
						'&lt;host&gt;_&lt;start_time&gt;', where &lt;host&gt; is either the requesting client's
						hostname or IP, and &lt;start_time&gt; is the time the tests started to run.
						</p> 

						<p>
						Eventually I want to add animation to the chemistry balancer's results page. 
						From what I have read, testing the animation itself must be done manually. 
						However, the tags that will delineate the elements to animate can be verified
						with the existing test gear.
						</p>

						<h3>Source Code</h3>
						<p>
						Source code for the chemistry reaction balancer tests is at <a href="https://github.com/b007patel/tutor-prez/test">tutor-prez/test</a> in my GitHub
						repository.
						</p>

EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
