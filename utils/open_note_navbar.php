<nav class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Première div avec l'icône de retour -->
        <div class="navbar-icon">
            <?php
            if ($noteType == "archived") {
                echo '<a href="index/archive_notes">';
            } else {
                echo '<a href="index">';
            }

            echo '<span class="material-symbols-outlined"> arrow_back_ios </span>';
            echo '</a>';
            ?>
        </div>


        <!-- Deuxième div avec quatre autres icônes -->
        <div class="navbar-icons" id="icons">
            <?php
            if ($noteType == "archived"){
                // delete
                echo '<a href="index/deleteNote/'. $note->getId() .'" class="icon-link">';
                echo ' <span style="font-variation-settings: \'FILL\' 0, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24; color: #FF0000;" class="material-symbols-outlined delete-icon"> delete_forever </span>';
                echo '</a>';
                // unarchived
                echo '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined">unarchive
</span></a>';
            } elseif ($noteType == "share"){
                // edite share
                echo $note->isEditor() ? '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> edit </span> </a>' : '';

            } elseif ($noteType == "edited"){
                // Save
                echo '<a href="#" class="icon-link">';
                echo ' <i class="fa-solid fa-floppy-disk"></i>';
                echo '</a>';
            }elseif ($noteType == "add"){
//                // Save
//                echo '<button type="submit" class="icon-link">';
//                echo ' <i class="fa-solid fa-floppy-disk"></i>';
//                echo '</button>';
                echo '';
            }else {
                // share
                echo '<a href="index/view-share" class="icon-link">';
                echo ' <span class="material-symbols-outlined"> share </span>';
                echo '</a>';
                // pinned
                echo $note->isPinned() ? '<a href="index/unpin/' . $note->getId() . '" class="icon-link"><span style="font-variation-settings: \'FILL\' 1, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24;" class="material-symbols-outlined"> push_pin </span></a>' : '<a href="index/pin/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> push_pin </span></a>';

                // archived
                echo $note->isArchived() ? '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> unarchive </span> </a>' : '<a href="index/archive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> archive </span></a>';

                // edited
                echo '<a href="EditText/note/'. $note->getId() .'" class="icon-link">';
                echo ' <span class="material-symbols-outlined"> edit </span>';
                echo '</a>';
            }
            ?>
        </div>
    </div>
</nav>

<div>
    <?php
    if ($noteType == "archived" || $noteType == "share" || $noteType == "edited" || $noteType == "normal") {
        echo '<h5 class="infoText"> Created ' . $messageCreate . '. Edited ' . $messageEdit . ' </h5>';
    }
    ?>

    </div>
