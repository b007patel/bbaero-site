<?php 
	$page_title = "Bubbly Bubbly Aero - Why?";

	include 'php/html-start-tmpl.php';

	include 'php/nav-tmpl.php';

	$heading = '"bbaero?" What gives?';
	$lhs_heading = 'A shout-out to my roots';
	$rhs_heading = 'Back in my day...';
	$lhs_html = <<<'EOD'
						<p>
						How many of us would be nowhere without our parents or our guardians? And 
						how hard is it to think of a unique site name?!??
						</p>

						<p>
						I used my mother's creativity to honor all she's done for me and my 
						family. <span id="show-aero"><a href="img/bbaero-bkg.jpg" 
						data-lightbox="aero-zoom" data-title="1970's era Rowntree Aero wrapper">
						Aero, the chocolate bar</a></span> is filled with bubbles. And ads for it 
						were all over the place in the Seventies. At some point in time one of 
						those ads inspired my mom to christen me with a nickname. "My bubbly, 
						bubbly Aero!" To this day, well into adulthood, she still uses that 
						nickname. I did a quick search, and barring a Polish and an Ohio-based 
						aerospace company, no one else was using "bbaero." So I figured, "Why not?"
						</p>

						<p>
						So, Mom, this website (for obvious reasons <i class="fa fa-smile-o"></i>) 
						couldn't be here without you. Thank you so much, even though you always 
						reply, <span id="mom-rant">"I'm your mother!! I DON'T NEED THANK 
						YOU'S!!!!".</span> From the bottom of my heart. <span class="glyphicon 
						glyphicon-heart"></span>
						</p>

						<p>
						I feel the same way about the rest of my family, even though their 
						nickanmes for me are NFSW. <i class="fa fa-smile-o"></i>
						</p>

EOD;

	$rhs_html = <<<'EOD'
						<p>Aero ads from the past:</p>
						<span class="advideo">
							<p><i>Dare We Compare</i> 1980s, 1990s:</p>
							<object data="https://www.youtube.com/embed/AvUKX55IAXM"></object>
							<p><i>Aero is Nothing</i> Movie Theatre 1980s, 1990s:</p>
							<object data="https://www.youtube.com/embed/XQhsHmXDd9M"></object>
						
						</span>

EOD;

	$bottom_html = <<<'EOD'


EOD;

	include 'php/main-tmpl.php';
	
	include 'php/footer-tmpl.php'; 
	
	include 'php/html-end-tmpl.php';
