<!DOCTYPE html>
<html lang="en">
	<?php
		$app = [
			'id' => 'response-analizer',
			'name' => 'Response Analyzer and Logger',
			'description' => 'Response analyzer and logger for the CenPOS integrated platforms',
			'logo' => 'integ.png',
			'logo_type' => 'image/png',
			'jquery' => false,
		];

		require '../../../resources/views/header.php';
	?>

	<body id="app-analyzer">
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