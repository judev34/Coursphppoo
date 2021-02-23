<?php ob_start()?>


<?= $msg; ?>
 
<br>
ERREUR 404
<br>
ERREUR 404
<br>
ERREUR 404
<br>
ERREUR 404
<br>
ERREUR 404
<br>
ERREUR 404

<?php
$content= ob_get_clean();
$titre = 'ERREUR 404';
require 'template.view.php';
?>