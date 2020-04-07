<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="vendor/bootstrap-4.4.1.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Oxanium&display=swap');

		body {
            background: #ddd linear-gradient(to bottom, #ccc, #888) fixed;
            margin-top: 6rem;
		}

		h2, .fancy, .navbar-brand, .btn {
			font-family: 'Oxanium', sans-serif;
		}

        .nav-link {
            cursor: pointer;
        }
	</style>
	<title>smallPBBG</title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="#">smallPBBG</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

<?php if (!is_null($this->user)) { ?>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<span class="nav-link" href="/">
					<i class="fa fa-fw fa-fab fa-home"></i>
					Duty Roster
				</span>

			</li>

            <?php if ($this->user->id === 1) {  ?>
                <li class="nav-item">
                    <span class="nav-link" href="/test">
                        <i class="fa fa-fw fa-fab fa-file"></i>
                        Test
                    </span>
                </li>
            <?php } ?>
            
		</ul>
	</div>
<?php } ?>

</nav>

<main role="main">
	<div class="container mb-4">
		<h2>
			<?=$this->page_title?>
			<small class="text-muted"><?=$this->page_subtitle?></small>
		</h2>
	</div>

 	<div class="container">

