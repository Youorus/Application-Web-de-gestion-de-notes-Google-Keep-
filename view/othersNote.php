<?php
require_once "view/displayNoteCard.php";

for ($i = 0; $i < count($notesOthers); $i++) {
    echo '<div class="col-sm-3">';
    echo '<div class="card card-custom">';
    displayNoteCard($notesOthers[$i]);
    echo '</div>';
    echo '</div>';
}
    ?>