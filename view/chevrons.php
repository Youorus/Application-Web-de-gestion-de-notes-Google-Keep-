<?php
echo '<div class="d-flex iconBox justify-content-between">';
echo '<form action="index/decrementWeight" method="POST">'; // Premier formulaire pour l'icône gauche
echo ' <input hidden="hidden" name="previousNote" value="3"> ';
echo '<button type="submit" class="btn btn-link" name="leftButton" value="' . $notesPinned[$i]->getId() . '"><i class="fa-solid fa-angles-left"></i></button>';
echo '</form>'; // Fermeture du premier formulaire

echo '<form action="index/incrementWeight" method="POST">'; // Deuxième formulaire pour l'icône droite
echo '<button type="submit" class="btn btn-link" name="rightButton" value="' . $notesPinned[$i]->getId() . '"><i class="fa-solid fa-angles-right"></i></button>';
echo '</form>'; // Fermeture du deuxième formulaire

echo '</div>';
?>
