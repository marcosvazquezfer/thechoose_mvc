<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<h1 class="bl"><?= i18n("Login") ?></h1>
<?= isset($errors["general"])?$errors["general"]:"" ?>

<form id="login" class="mod1" action="index.php?controller=usuarios&amp;action=login" method="POST">
	<label><?= i18n("Email")?> <input type="text" name="email"></label>
	<label><?= i18n("Password")?> <input type="password" name="passwd"></label>
	<br>
	<input type="submit" class="btn btn-default" value="<?= i18n("LOGIN") ?>">
</form>

<?php $view->moveToFragment("icons");?>
<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

	<a href="index.php?controller=usuarios&amp;action=register"><input type="image" src="././css/img/register.png"></a>

</div>

