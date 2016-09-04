<html>
<title><?php
	echo "$page_title";
	if (strpos(strtolower($page_title), "feedback") === false) {
		if (!empty($_SESSION['email_result'])) {
			unset($_SESSION['email_result']);
		}
	}
?></title>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/css/lightbox.css">
	<link rel="stylesheet" href="/css/styles.css">
</head>
<?php
    include $_SERVER["DOCUMENT_ROOT"].'/php/vars.php';
?>
<body class="no-js">
