<?php
echo '<div class="d-flex iconBox justify-content-between">';
echo '<form action="index/decrementWeight" method="POST">'; // Premier formulaire pour l'icône gauche
echo '<input type="hidden"  name="leftButton" value="' . $notesPinned[$i]->getId() . '">';
if (isset($notesPinned[$i - 1])) { // Vérifie si la note suivante existe
    echo '<input type="hidden"  name="preNote" value="' . $notesPinned[$i - 1]->getId() . '">';
} else {
    echo '<input type="hidden"  name="preNote" value="0">';
}
echo '<button type="submit" class="btn btn-link"><i class="fa-solid fa-angles-left"></i></button>';
echo '</form>'; // Fermeture du premier formulaire



echo '<form action="index/incrementWeight" method="POST">'; // Deuxième formulaire pour l'icône droite
echo '<input type="hidden"  name="rightButton" value="' . $notesPinned[$i]->getId() . '">';
if (isset($notesPinned[$i + 1])) { // Vérifie si la note suivante existe
    echo '<input type="hidden"  name="nextNote" value="' . $notesPinned[$i + 1]->getId() . '">';
} else {
    echo '<input type="hidden"  name="nextNote" value="0">';
}
echo '<button type="submit" class="btn btn-link"><i class="fa-solid fa-angles-right"></i></button>';
echo '</form>'; // Fermeture du deuxième formulaire

echo '</div>';


?>
