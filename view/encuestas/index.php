<?php
//file: view/encuestas/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$encuestas = $view->getVariable("encuestas");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "encuestas");

?>

<p class="blu">
  <?= i18n("The solution to your problems has arrived.")?> <br>
  <?= i18n("The Chose! arrives to facilitate the election")?> <br>
  <?= i18n("to set up a meeting, that will be")?> <br>
  <?= i18n("easier to organize meetings with more")?> <br>
  <?= i18n("than two people involved.")?> <br>
  <?= i18n("Don't doubt and be encouraged to try!")?> <br> 
</p>
<br>

<form action="index.php?controller=encuestas&amp;action=add" method="POST" role="form" class="center-block">

    <button type="submit" class="btn btn-default"><?= i18n("CREATE")?></button>

</form><br>

<table>

    <thead>

        <tr class="first">

            <th scope="col" rowspan="2"></th>
            <th scope="col" colspan="2"><?= i18n("MON")?> <br> 22 <br><?= i18n("OCT")?> </th>
            <th scope="col" colspan="2"><?= i18n("TUE")?> <br> 23 <br> <?= i18n("OCT")?></th>
            <th class="hidden-xs" scope="col" colspan="2"><?= i18n("WED")?> <br> 24 <br> <?= i18n("OCT")?></th>
            <th class="hidden-xs" scope="col" colspan="2"><?= i18n("THU")?> <br> 25 <br> <?= i18n("OCT")?></th>

        </tr>

        <tr class="second">

            <th scope="col">16:00 <br> - <br> 17:00</th>
            <th scope="col">17:00 <br> - <br> 18:00</th>
            <th scope="col">16:00 <br> - <br> 17:00</th>
            <th scope="col">17:00 <br> - <br> 18:00</th>
            <th class="hidden-xs" scope="col">16:00 <br> - <br> 17:00</th>
            <th class="hidden-xs" scope="col">17:00 <br> - <br> 18:00</th>
            <th class="hidden-xs" scope="col">16:00 <br> - <br> 17:00</th>
            <th class="hidden-xs" scope="col">17:00 <br> - <br> 18:00</th>

        </tr>

    </thead>

    <tbody>

        <tr>

            <th scope="row">Persona</th>
            <td><input type="image" value="1" src="././css/img/smile.png"></td>
            <td></td>
            <td></td>
            <td><input type="image" value="1" src="././css/img/smileall.png"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"><input type="image" value="1" src="././css/img/smile.png"></td>
            <td class="hidden-xs"></td>

        </tr>

        <tr>

            <th scope="row">Persona</th>
            <td></td>
            <td><input type="image" value="1" src="././css/img/smile.png"></td>
            <td><input type="image" value="1" src="././css/img/smile.png"></td>
            <td><input type="image" value="1" src="././css/img/smileall.png"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"></td>

        </tr>

        <tr class="last">

            <th scope="row">Persona</th>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="image" value="1" src="././css/img/smileall.png"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"><input type="image" value="1" src="././css/img/smile.png"></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xs"><input type="image" value="1" src="././css/img/smile.png"></td>

        </tr>

    </tbody>

</table>
<br><br>

<?php $view->moveToFragment("icons");?>


  <?php
    //show actions ONLY for the author of the post (if logged)
    if (isset($currentuser)): 
  ?>

    <a href="index.php?controller=usuarios&amp;action=logout"><input type="image" src="././css/img/logout.png"></a>

  <?php else: ?>

    <a href="index.php?controller=usuarios&amp;action=login"><input type="image" src="././css/img/login.png"></a>
    <a href="index.php?controller=usuarios&amp;action=register"><input type="image" src="././css/img/register.png"></a>

  <?php endif ?>



<?php $view->moveToFragment("navigation");?>
<li><a href="index.php?controller=encuestas&amp;action=viewMyPolls"><?= i18n("VIEW MY POLLS")?></a></li>
