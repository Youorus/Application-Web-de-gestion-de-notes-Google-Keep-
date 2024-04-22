<?php
require_once "view/displayNoteCard.php";

for ($i = 0; $i < count($notesPinned); $i++) {
    echo '<div class="custom-card">';
    echo '<div class="card">';
    displayNoteCard($notesPinned[$i]) ;
    echo '</div>';
    echo '</div>';
    }
?>