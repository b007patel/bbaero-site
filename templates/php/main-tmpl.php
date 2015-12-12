	<div id="script-warn" class="col-xs-offset-2 col-xs-8">
		<p>
		Please wait for a few seconds. The network may be slow.
		</p>
		
		<p>
		If this is visible after a few seconds, then javascript is not enabled. This site needs 
		it running. Please disable any script blockers.
		</p>
	</div>
			  
	<div id="main" class="container-fluid">
	
		<div id="home-page">
			<h2 class="text-center"><?php echo "$heading"; ?></h2>
			<div class="row">
				<div id="lhs" class="col-sm-12 col-md-6">
					<h3><?php echo "$lhs_heading"; ?></h3>
					<div class="body-text">
<?php
	echo "$lhs_html";
?>
					</div>
				</div>
				<div id="rhs" class="col-sm-12 col-md-6">
					<h3><?php echo "$rhs_heading"; ?></h3>
					<div class="body-text">
<?php
	echo "$rhs_html";
?>
					</div>
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