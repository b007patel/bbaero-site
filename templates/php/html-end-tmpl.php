
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="/js/lightbox.min.js"></script> 
	<script src="/js/custom.js"></script> 
<?php
	if (isset($script_call) && strlen($script_call) > 0) {
		echo <<<'ESC'
	<script>

ESC;
		echo chr(9).chr(9).$script_call;
		echo <<<'ESC'
	</script>

ESC;
	}
?>
</body>
</html>
