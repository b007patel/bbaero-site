	<noscript>
		<div id="script-warn">
			<h1>Javascript is not enabled. This site needs it running. Please disable any script blockers.</h1>
		</div>
	</noscript>
			  
	<div id="main" class="container-fluid">
	
		<div id="home-page">
			<h2 class="text-center"><?php echo "$heading"; ?></h2>
			<div class="row">
				<div class="col-xs-6"><h3><?php echo "$lhs_heading"; ?></h3></div>
				<div class="col-xs-6"><h3><?php echo "$rhs_heading"; ?></h3></div>
			</div>
			<div class="row">
				<div id="lhs" class="col-xs-6">
<?php
	echo "$lhs_html";
?>
				</div>
				<div id="rhs" class="col-xs-6">
<?php
	echo "$rhs_html";
?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
<?php
	echo "$bottom_html";
?>
				</div>
			</div>
		</div>