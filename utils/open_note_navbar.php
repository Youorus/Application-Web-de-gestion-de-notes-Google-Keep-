<nav class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Première div avec l'icône de retour -->
        <div class="navbar-icon">
            <a href="index/index">
                <i class="fas fa-arrow-left "></i>
            </a>
        </div>

        <!-- Deuxième div avec quatre autres icônes -->
        <div class="navbar-icons" id="icons">
            <?php
            if ($noteType == "archived"){
                // delete
                echo '<a href="index/deleteNote/'. $note->getId() .'" class="icon-link">';
                echo ' <i class="fa-solid  fa-calendar-xmark"></i>';
                echo '</a>';
                // unarchived
                echo '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><i class="fa-solid fa-box-open"></i></a>';
            } elseif ($noteType == "shared"){
                // edite share
                echo '<a href="#" class="icon-link">';
                echo ' <i class="fa-regular  fa-pen-to-square"></i>';
                echo '</a>';
            } elseif ($noteType == "edited"){
                // Save
                echo '<a href="#" class="icon-link">';
                echo ' <i class="fa-solid fa-floppy-disk"></i>';
                echo '</a>';
            } else {
                // share
                echo '<a href="index/view-share" class="icon-link">';
                echo '  <i class="fa-solid  fa-share-nodes"></i>';
                echo '</a>';
                // pinned
                echo $note->isPinned() ? '<a href="index/unpin/' . $note->getId() . '" class="icon-link"><i class="fas fa-toggle-on "></i></a>' : '<a href="index/pin/' . $note->getId() . '" class="icon-link"><i class="fas fa-thumbtack "></i></a>';

                // archived
                echo $note->isArchived() ? '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><i class="fa-solid   fa-box-open"></i></a>' : '<a href="index/archive/' . $note->getId() . '" class="icon-link"><i class="fa-solid  fa-box-archive"></i></a>';

                // edited
                echo '<a href="index/edit_text_note/'. $note->getId() .'" class="icon-link">';
                echo ' <i class="fa-regular  fa-pen-to-square"></i>';
                echo '</a>';
            }
            ?>
        </div>
    </div>
</nav>

<div>
        <h5 class="infoText"> Created <?= $messageCreate ?>. Edited <?= $messageEdit ?> </h5>
    </div>
