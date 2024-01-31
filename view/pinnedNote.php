<?php
require_once "view/displayNoteCard.php";


for ($i = 0; $i < count($notesPinned); $i++) {
    echo '<div class="col-md-4">';
    echo '<div class="card">';
    displayNoteCard($notesPinned[$i], $minweight, $maxweight) ;
    echo '</div>';
    echo '</div>';
    }
?>