<?php
//file: view/encuestas/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$encuesta = $view->getVariable("encuesta");
$encuestaHuecos = $view->getVariable("encuestaHuecos");
$currentuser = $view->getVariable("currentusername");
$newhueco = $view->getVariable("hueco");
$encuestaParticipantes = $view->getVariable("encuestaParticipantes");
$encuestaSelecciones = $view->getVariable("encuestaSelecciones");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View encuesta");

?>
<h1 class="bl"><?= i18n("Title").": ".htmlentities($encuestaHuecos->getTitulo()) ?></h1>

<h4><?= i18n("Link").": ".htmlentities($encuestaHuecos->getLink()) ?></h4><br>

<table class="hidden-xs hidden-sm">

	<thead>

		<tr class="first">
							
			<th scope="col" rowspan="2">
				
				<a href="index.php?controller=encuestas&amp;action=participar&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" id="participate" src="././css/img/participate.png"></a>
                <a href="index.php?controller=encuestas&amp;action=editParticipation&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" id="edit" src="././css/img/edit_p.png"></a>

                <?php if ($encuesta->getEmail() == $currentuser): ?>

					<a href="index.php?controller=encuestas&amp;action=edit&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>""><input type="image" src="././css/img/modify.png"></a>

				<?php else: ?>

					<a href=""></a>

				<?php endif ?>

			</th>

			<?php foreach($encuestaHuecos->getHuecos() as $hueco): ?>

				<!--<th scope="col" colspan="2">-->
				<th scope="col">
					<?= sprintf(i18n("%s"),$hueco->getFecha()) ?>
				</th>

			<?php endforeach; ?>

		</tr>

		<tr class="second">

			<?php foreach($encuestaHuecos->getHuecos() as $hueco): ?>

				<th scope="col">
					<?= sprintf(i18n("%s \n - \n %s"),$hueco->getHoraInicio(), $hueco->getHoraFin()) ?>
				</th>

			<?php endforeach; ?>

		</tr>

	</thead>

	<tbody>

		<?php foreach($encuestaParticipantes->getParticipantes() as $participante): ?>

			<tr>

              	<th scope="row">

              		<?= sprintf("%s",$participante->getIdParticipante()) ?>
              			
              	</th>

              	<?php foreach($encuestaSelecciones->getSelecciones() as $seleccion): ?>

              		<?php if ($participante->getIdParticipante() == $seleccion->getEmail() ): ?>

              			<?php if ($seleccion->getSeleccion() == 1): ?>

							<td><input type="image" value="1" src="././css/img/smile.png"></td>

						<?php else: ?>

							<?php if ($seleccion->getSeleccion() == 0): ?>

								<td></td>

							<?php endif ?>

						<?php endif ?>
					
					<?php endif ?>

              	<?php endforeach; ?>

            </tr>

        <?php endforeach; ?>

	</tbody>

</table>

<table class="hidden-lg hidden-md">

	<thead>

		<tr class="first">
							
			<th scope="col" colspan="3">
				
				<a href="index.php?controller=encuestas&amp;action=participar&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" id="participate" src="././css/img/participate.png"></a>
                <a href="index.php?controller=encuestas&amp;action=editParticipation&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>"><input type="image" id="edit" src="././css/img/edit_p.png"></a>
                
                <?php if ($encuesta->getEmail() == $currentuser): ?>

					<a href="index.php?controller=encuestas&amp;action=edit&amp;idEncuesta=<?= $encuesta->getIdEncuesta()?>""><input type="image" src="././css/img/modify.png"></a>

				<?php else: ?>

					<a href=""></a>

				<?php endif ?>

			</th>

		</tr>

	</thead>

	<tbody>

		<?php foreach($encuestaHuecos->getHuecos() as $hueco): ?>

			<tr>

				<td scope="col">
					<?= sprintf(i18n("%s"),$hueco->getFecha()) ?>
				</td>

				<td scope="col">
					<?= sprintf(i18n("%s \n - \n %s"),$hueco->getHoraInicio(), $hueco->getHoraFin()) ?>
				</td>

				<td scope="col">

					<?php $numParticipantes = count($encuestaParticipantes->getParticipantes()); ?>

					<?php $cont = 0 ?>

					<?php foreach($encuestaSelecciones->getSelecciones() as $seleccion): ?>

						<?php if ($seleccion->getFecha() == $hueco->getFecha() ): ?>

							<?php if ($seleccion->getSeleccion() == 1 ): ?>

								<?php $cont = $cont + 1; ?>

								

							<?php endif ?>

						<?php endif ?>

					<?php endforeach; ?>

					<?php if ($numParticipantes == $cont ): ?>

						<input type="image" value="1" src="././css/img/smileall.png">

					<?php else: ?>

						<?= sprintf(i18n("%d votos"),$cont) ?>

					<?php endif ?>

				</td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>

<?php $view->moveToFragment("icons");?>
<a href="index.php?controller=usuarios&amp;action=logout"><input type="image" src="././css/img/logout.png"></a>

<?php $view->moveToFragment("navigation");?>
<li><a href="index.php"><?= i18n("BEGIN")?></a></li>
<li><a href="index.php?controller=encuestas&amp;action=viewMyPolls"><?= i18n("VIEW MY POLLS")?></a></li>
<li><a href="index.php?controller=encuestas&amp;action=add"><button type="submit" class="btn btn-default"><?= i18n("CREATE")?></button></a></li>
