<?php
//file: view/encuestas/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$encuesta = $view->getVariable("encuesta");
$currentuser = $view->getVariable("currentusername");
$encuestaParticipantes = $view->getVariable("encuestaParticipantes");
$encuestaSelecciones = $view->getVariable("encuestaSelecciones");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Participar encuesta");

?><h1 class="bl"><?= i18n("Poll").": ".htmlentities($encuesta->getTitulo()) ?></h1><br>

<form id="ep" action="index.php?controller=encuestas&amp;action=participar&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>" method="POST">

	<table>

		<thead>

			<tr>
								
				<th scope="col" colspan="3">

					<input class="btn btn-default" type="submit" name="submit" value="<?= i18n("SEND") ?>">

				</th>

			</tr>

		</thead>

		<tbody>

			<?php $cont = 0; ?>

			<?php foreach($encuesta->getHuecos() as $hueco): ?>

				<tr>

					<!--<th scope="col" colspan="2">-->
					<th scope="col">
						<?= sprintf(i18n("%s"),$hueco->getFecha()) ?>
					</th>

					<th scope="col">
						<?= sprintf(i18n("%s \n - \n %s"),$hueco->getHoraInicio(), $hueco->getHoraFin()) ?>
					</th>

					<?php $check = "checkbox" . $cont; ?>

		      		<?php if ($hueco->getHoraInicio() != null): ?>

						<td>

							<input name="checkbox[]" id="<?php echo $check ?>" type="checkbox" value="<?php echo $hueco->getFecha().$hueco->getHoraInicio()?>"/>
		        			<label for="<?php echo $check ?>"></label>

						</td>
					
					<?php endif ?>

					<?php $cont = $cont+1; ?>

				</tr>

			<?php endforeach; ?>

		</tbody>

	</table>

</form>

<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

    <a href="index.php?controller=encuestas&amp;action=view&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" src="././css/img/cancel.png"></a>

</div><br>

<?php $view->moveToFragment("icons");?>
<div class="btn-group col-lg-2 col-md-3 col-sm-3 col-xs-2">

	<a href="index.php?controller=usuarios&amp;action=logout"><input type="image" src="././css/img/logout.png"></a>

</div>
