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
	
		<div id="newspaper-page">
			<h2 class="text-center"><?php echo "$heading"; ?></h2>
<?php
	$has_lhs_html = trim( $lhs_html ) != '';
	$has_rhs_html = trim( $rhs_html ) != '';
	$has_bottom_html = trim( $bottom_html ) != '';

	if ( $has_lhs_html || $has_rhs_html ) {
		echo <<< 'EOD'
			<div class="row">

EOD;
		if ( $has_lhs_html ) {
			echo <<< 'EOD'
				<div id="lhs" class="col-sm-12 col-md-6">
					<h3>
EOD;
			echo "$lhs_heading";
			echo <<< 'EOD'
</h3>
					<div class="body-text">

EOD;
			echo "$lhs_html";
			echo <<< 'EOD'
					</div>
				</div>

EOD;
		}
		if ( $has_rhs_html ) {
			echo <<< 'EOD'
				<div id="rhs" class="col-sm-12 col-md-6">
					<h3>
EOD;
			echo "$rhs_heading";
			echo <<< 'EOD'
</h3>
					<div class="body-text">

EOD;
			echo "$rhs_html";
			echo <<< 'EOD'
					</div>
				</div>

EOD;
		}
		echo <<< 'EOD'
			</div>

EOD;
	}
	if ( $has_bottom_html ) {
		echo <<< 'EOD'
			<div class="row">
				<div class="col-xs-12">

EOD;
		echo "$bottom_html";
		echo <<< 'EOD'
				</div>
			</div>
EOD;
	}
?>

		</div>

