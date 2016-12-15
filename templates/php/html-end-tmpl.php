<?php
if (!array_key_exists('have_endhtml', $GLOBALS)) {
	$GLOBALS['have_endhtml'] = false;
}
if ($GLOBALS['have_endhtml'] == false) {
	echo <<<'EOB'

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="/js/lightbox.min.js"></script> 
	<script src="/js/site-common.js"></script> 

EOB;
	if (isset($custom_scripts)) {
		$cjs = explode(",", $custom_scripts);
		foreach ($cjs as $i=>$js_name) {
			$sl = chr(9).'<script src="'.$js_name.'">';
			$sl .= '</script>'.chr(10);
			echo $sl;
		}
	}
		
	if (isset($script_call) && strlen($script_call) > 0) {
		echo <<<'ESC'
	<script>

ESC;
		echo chr(9).chr(9).$script_call;
		echo <<<'ESC'
	</script>

ESC;
	}
	echo <<<'EOD'

	</body>
</html>
EOD;
}
?>
