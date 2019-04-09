<?php
//file: view/encuestas/edit.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$encuesta = $view->getVariable("encuesta");
$encuestaHueco = $view->getVariable("encuestaHueco");
$newhole = $view->getVariable("hueco");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Poll");

?><h1 class="bl"><?= i18n("Modify Poll") ?></h1>

<form action="index.php?controller=encuestas&amp;action=edit" class="mod1" method="POST">

	<label><?= i18n("Title") ?> <input type="text" name="titulo"
	value="<?=$encuesta->getTitulo() ?>">
	<?= isset($errors["titulo"])?i18n($errors["titulo"]):"" ?></label><br>

	<label><?= i18n("Link") ?>
	<input type="text" name="link"
	value="<?= isset($_POST["link"])?$_POST["link"]:$encuesta->getLink() ?>" id="link" readonly>
	<?= isset($errors["link"])?i18n($errors["link"]):"" ?></label><br>

	<input type="hidden" name="idEncuesta" value="<?= $encuesta->getIdEncuesta() ?>">
	<input type="submit" class="btn btn-default" name="submit" value="<?= i18n("EDIT")?>">

</form>

<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

  	<a href="index.php?controller=huecos&amp;action=add&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" src="././css/img/addColumn.png"></a>
    <a href="index.php?controller=huecos&amp;action=delete&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" src="././css/img/deleteColumn.png"></a>

</div>

<table>

	<thead>

		<tr class="first">
							
			<th scope="col" rowspan="2"></th>

			<?php foreach($encuestaHueco->getHuecos() as $hueco): ?>

				<!--<th scope="col" colspan="2">-->
				<th scope="col">
					<?= sprintf(i18n("%s"),$hueco->getFecha()) ?>
				</th>

			<?php endforeach; ?>

		</tr>

		<tr class="second">

			<?php foreach($encuestaHueco->getHuecos() as $hueco): ?>

				<th scope="col">
					<?= sprintf(i18n("%s \n - \n %s"),$hueco->getHoraInicio(), $hueco->getHoraFin()) ?>
				</th>

			<?php endforeach; ?>

		</tr>

	</thead>

</table>

<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

  	<a href="index.php?controller=encuestas&amp;action=view&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" src="././css/img/ok.png"></a>
    <a href="index.php?controller=encuestas&amp;action=viewMyPolls"><input type="image" src="././css/img/cancel.png"></a>

</div><br>

<?php $view->moveToFragment("icons");?>

<a href="index.php?controller=usuarios&amp;action=logout"><input type="image" src="././css/img/logout.png"></a>

<?php $view->moveToFragment("navigation");?>
<li><a href="index.php"><?= i18n("BEGIN")?></a></li>
<li><a href="index.php?controller=encuestas&amp;action=viewMyPolls"><?= i18n("VIEW MY POLLS")?></a></li>

