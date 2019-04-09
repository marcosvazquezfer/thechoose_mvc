<?php
//file: view/usuarios/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$usuario = $view->getVariable("usuario");
$view->setVariable("title", "Register");
?>

<h1><?= i18n("Register")?></h1>

<form action="index.php?controller=usuarios&amp;action=register"  class="mod1" method="POST">

	<label><?= i18n("Email")?> <input type="text" name="email"
	value="<?= $usuario->getEmail() ?>">
	<?= isset($errors["email"])?i18n($errors["email"]):"" ?></label><br>

	<label><?= i18n("Complete Name")?> <input type="text" name="nombreCompleto"
	value="<?= $usuario->getNombreCompleto() ?>">
	<?= isset($errors["nombreCompleto"])?i18n($errors["nombreCompleto"]):"" ?></label><br>

	<label><?= i18n("Password")?> <input type="password" name="passwd"
	value="">
	<?= isset($errors["passwd"])?i18n($errors["passwd"]):"" ?></label><br>

	<input type="submit" class="btn btn-default" value="<?= i18n("REGISTER")?>">
	
</form>

<?php $view->moveToFragment("icons");?>
<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

	<a href="index.php?controller=encuestas&amp;action=index"><input type="image" src="././css/img/back.png"></a>

</div>
