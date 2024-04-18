<?php
echo '<div class="d-flex iconBox justify-content-between">';
echo '<form action="index/decrementWeight" method="POST">'; // Premier formulaire pour l'icône gauche
echo '<input type="hidden"  name="leftButton" value="' . $notesOthers[$i]->getId() . '">';
if (isset($notesOthers[$i - 1])) { // Vérifie si la note suivante existe
    echo '<input type="hidden"  name="preNote" value="' . $notesOthers[$i - 1]->getId() . '">';
} else {
    echo '<input type="hidden"  name="preNote" value="0">';
}
echo '<button type="submit" class="btn btn-link"><i class="fa-solid fa-angles-left"></i></button>';
echo '</form>'; // Fermeture du premier formulaire



echo '<form action="index/incrementWeight" method="POST">'; // Deuxième formulaire pour l'icône droite
echo '<input type="hidden"  name="rightButton" value="' . $notesOthers[$i]->getId() . '">';
if (isset($notesOthers[$i + 1])) { // Vérifie si la note suivante existe
    echo '<input type="hidden"  name="nextNote" value="' . $notesOthers[$i + 1]->getId() . '">';
} else {
    echo '<input type="hidden"  name="nextNote" value="0">';
}
echo '<button type="submit" class="btn btn-link"><i class="fa-solid fa-angles-right"></i></button>';
echo '</form>'; // Fermeture du deuxième formulaire

echo '</div>';


?>
