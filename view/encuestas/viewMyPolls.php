<?php
//file: view/encuestas/viewMyPolls.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$participantes = $view->getVariable("participantes");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View My Polls");

?>

<h1 class="bl"><?= i18n("My Polls") ?></h1><br>

<table id="vmp">

	<thead>

		<tr>
							
			<th scope="col" id="f1"><?= i18n("Polls") ?></th>


		</tr>

	</thead>

	<tbody>

        <?php foreach($participantes as $participante): ?>

			<?php
				//show actions ONLY for the author of the post (if logged)
				if (isset($currentuser) && $currentuser == $participante->getIdParticipante()): 
			?>

				<tr>

	              	<td scope="row">

	              		<a href="index.php?controller=encuestas&amp;action=view&amp;idEncuesta=<?= $participante->getIdEncuesta()?>"><?= sprintf("%s",$participante->getIdEncuesta()) ?></a>
	              			
	              	</td>

	            </tr>

            <?php endif ?>

        <?php endforeach; ?>

	</tbody>

</table><br>

<?php $view->moveToFragment("icons");?>
<a href="index.php?controller=usuarios&amp;action=logout"><input type="image" src="././css/img/logout.png"></a>

<?php $view->moveToFragment("navigation");?>
<li><a href="index.php"><?= i18n("BEGIN")?></a></li>
<li><a href="index.php?controller=encuestas&amp;action=add"><button type="submit" class="btn btn-default"><?= i18n("CREATE")?></button></a></li>