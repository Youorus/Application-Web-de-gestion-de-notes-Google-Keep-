<?php
require_once "view/displayNoteCard.php";
if (empty($notesArchives)){
    echo '<h5 class="infoText"> Archives notes is empty. </h5>';
}else{
    for ($i = 0; $i < count($notesArchives); $i++) {
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        displayNoteCard($notesArchives[$i]);
        echo '</div>';
        echo '</div>';
    }
}

?>