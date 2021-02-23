<?php 

// require_once 'Livres.class.php';
// $l1 = new Livre(1,"Algorithmique selon H2PROG",300,"algo.png"); TESTS EN DUR
// $l2 = new Livre(2,"Le virus Asiatique",200,"virus.png");
// $l3 = new Livre(3,"La France du 19ème",100,"france.png");
// $l4 = new Livre(4,"Le JavaScript Client",500,"JS.png");
// require_once 'LivreManager.class.php';
// $livreManager = new LivreManager;
// $livreManager->ajoutLivre($l1); TESTS EN DUR
// $livreManager->ajoutLivre($l2);
// $livreManager->ajoutLivre($l3);
// $livreManager->ajoutLivre($l4);
// $livreManager->chargementLivres();

ob_start();

if (!empty($_SESSION['alert'])) :
?>
<div class="alert alert-<?= $_SESSION['alert']["type"] ?>" role="alert">
    <?= $_SESSION['alert']["msg"] ?>
</div>

<?php 
unset($_SESSION['alert']);
endif; ?>

<table class="table text-center">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>
    <?php 
    // $livres = $livreManager->getLivres();
    foreach ($livres as $livre) { ?>
    <tr>
        <td class="align-middle"><img src="public/images/<?= $livre->getImage(); ?>" width="60px;"></td>
        <td class="align-middle"><a href="<?= URL ?>livres/l/<?=$livre->getId();?>"><?= $livre->getTitre();?></a></td>
        <td class="align-middle"><?= $livre->getNbPages(); ?></td>
        <td class="align-middle"><a href="<?= URL ?>livres/m/<?= $livre->getId(); ?>" class="btn btn-warning">Modifier</a></td>
        <td class="align-middle">
            <form method="post" action="<?= URL ?>livres/s/<?= $livre->getId(); ?>" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                <button class="btn btn-danger" type="submit">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<a href="<?= URL ?>livres/a" class="btn btn-success d-block">Ajouter</a>

<?php
$content = ob_get_clean();
$titre = "Les livres de la bibliothèque";
require "template.view.php";
?>