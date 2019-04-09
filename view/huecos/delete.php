<?php
//file: view/posts/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$hueco = $view->getVariable("hueco");
$encuestaid = $view->getVariable("encuesta");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Delete Hole");

?><h1 class="bl"><?= i18n("Delete Hole")?></h1><br>

<form action="index.php?controller=huecos&amp;action=delete&amp;idEncuesta=<?=$encuestaid?>" class= "mod1" method="POST">
	<label><?= i18n("Date") ?>: <input type="date" name="fecha"
	value="<?= $hueco->getFecha() ?>">
	<?= isset($errors["fecha"])?i18n($errors["fecha"]):"" ?></label><br>

	<label><?= i18n("Time Start") ?>: <input type="time" name="horaInicio"
	value="<?= $hueco->getHoraInicio() ?>">
	<?= isset($errors["horaInicio"])?i18n($errors["horaInicio"]):"" ?></label><br>

	<label><?= i18n("Time Finish") ?>: <input type="time" name="horaFin"
	value="<?= $hueco->getHoraFIn() ?>">
	<?= isset($errors["horaFin"])?i18n($errors["horaFin"]):"" ?></label><br>

	<input type="submit" name="submit" class="btn btn-default" value="<?= i18n("DELETE") ?>">
</form>

<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

    <a href="index.php?controller=encuestas&amp;action=edit&amp;idEncuesta=<?= $encuestaid?>"><input type="image" src="././css/img/cancel.png"></a>

</div><br>