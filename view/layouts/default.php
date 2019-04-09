<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<link rel="shortcut icon" href="./css/img/smileall.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	<!--JQuery-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
	
	<link rel="stylesheet" href="css/estilo.css"></link>

	<!--Links necesarios para las fuentes elegidas-->
	<link href="https://fonts.googleapis.com/css?family=Bungee+Inline" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Monoton" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">

	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs">
	</script>
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
</head>
<body>
	<!-- header -->
	<div class="container-fluid">

		<header class="row">

			<h1 class="col-lg-offset-1 col-lg-10 col-md-offset-2 col-md-9 col-sm-offset-2 col-sm-9 col-xs-offset-2 col-xs-10"><?= i18n("The chose!")?></h1>

			<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

	  			<?= $view->getFragment("icons") ?>

			</div>

			
		</header>

		<div class="row">

	        <nav class="navbar navbar-custom" role="navigation">
	          <!-- El logotipo y el icono que despliega el menú se agrupan
	               para mostrarlos mejor en los dispositivos móviles -->
	          <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse"
	                    data-target=".navbar-ex1-collapse">
	              <span class="sr-only">Desplegar navegación</span>
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	            </button>
	          </div>
	         
	          <!-- Agrupar los enlaces de navegación, los formularios y cualquier
	               otro elemento que se pueda ocultar al minimizar la barra -->
	          <div class="collapse navbar-collapse navbar-ex1-collapse">

	            <ul class="nav navbar-nav navbar-right index">

	              	<?= $view->getFragment("navigation") ?>

	            </ul>
	         
	            <ul class="nav navbar-nav navbar-right">
	              
	              <li class="dropdown">
	                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                  <img src="././css/img/world.png"> <b class="caret"></b>
	                </a>
	                <ul class="dropdown-menu">
	                  	<?php
						include(__DIR__."/language_select_element.php");
						?>
	                </ul>
	              </li>
	            </ul>
	          </div>
	        </nav>

			<article class="col-xs-12 col-sm-12">
	      
	      		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>

			</article>

		</div>

	</div>

	<footer>
	      
	    <p><?= i18n("Created by @lasouto & @mvfernandez3")?></p>

	</footer>

</body>
</html>
