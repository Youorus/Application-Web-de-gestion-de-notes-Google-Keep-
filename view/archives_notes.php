<?php
require_once "view/displayNoteCard.php";
for ($i = 0; $i < count($notesArchives); $i++) {
    echo '<div class="col-md-4">';
    echo '<div class="card">';
    displayNoteCard($notesArchives[$i]);
    echo '</div>';
    echo '</div>';
}
?>