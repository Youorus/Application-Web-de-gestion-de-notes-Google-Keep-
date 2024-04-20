<?php
require_once "view/displayNoteCard.php";

for ($i = 0; $i < count($notesOthers); $i++) {
    echo '<div class="col-md-4">';
    echo '<div class="card">';
    displayNoteCard($notesOthers[$i]);
    echo '</div>';
    echo '</div>';
}
    ?>