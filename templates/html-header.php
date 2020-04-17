<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="icon" type="image/png" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="vendor/bootstrap-4.4.1.min.css">
	<link href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Oxanium&display=swap');

		body {
			/*background: #ddd linear-gradient(to bottom, #ccc, #888) fixed;*/
			margin-top: 6rem;
		}

		h2, .card-title, .card-subtitle, .card-header, .fancy, .navbar-brand, .btn {
			font-family: 'Oxanium', sans-serif;
		}

		.nav-link {
			cursor: pointer;
		}
	</style>
    <?php
        $css_file = strtolower(substr(get_class($this), strrpos(get_class($this), '\\')+1)) . '.css';
        if (file_exists(__DIR__ . '/../public/css/' . $css_file)) {
            echo '<link rel="stylesheet" href="css/'.$css_file.'">';
        }
    ?>
	<title>smallPBBG</title>
</head>
<body class="bg-secondary">
