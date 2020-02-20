<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Response analyzer and logger for the CenPOS integrated platforms">
		<meta name="author" content="Jonathan Estrella">

		<title>Integrations Response Analyzer and Logger - QA Tools</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" integrity="sha256-piqEf7Ap7CMps8krDQsSOTZgF+MU/0MPyPW2enj5I40=" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php if (isset($_SERVER["PATH_INFO"])) echo '../' ?>../static/css/main.css">
	</head>

	<body>
		<?php		
		// Get data structure from URL
		$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], '/') : false;
		$mod = 'parse';

		if ($path) {
			$path_parts = explode('/', $path);
			$mod = $path_parts[0];
		}
		
		switch ($mod) {
			case 'parse':
				require('parse.php');
				break;
			case 'view':
				require('view.php');
				break;
			case 'truncate':
				require('trunc.php');
				break;
			default:
				require('error.php');
		}
		?>
	</body>
</html>