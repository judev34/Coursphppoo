<?php ob_start(); ?>

<div class="row">
    <div class="col-6">
        <img src="<?= URL ?>public/images/<?= $livre->getImage(); ?>" alt="couverture de livre">
    </div>
    <div class="col-6">
        <h2>Titre : <?= $livre->getTitre(); ?></h2>
        <p>Nombre de pages : <?= $livre->getNbPages(); ?></p>
    </div>
</div>

<?php

$content = ob_get_clean();
$titre = $livre->getTitre();
require "template.view.php";

?>