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
                echo '<form action="delete" method="post">';
                echo ' <input type="hidden" id="id_item" name="idNote" value="' . $note->getId() . '" >';
                echo ' <button style="font-variation-settings: \'FILL\' 0, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24; color: #FF0000;" class="material-symbols-outlined delete-icon"> delete_forever </button>';
                echo '</form>';
                // unarchived
                echo '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined">unarchive
</span></a>';
            } elseif ($noteType == "share"){
                // edite share
                if ($note->getType() == NoteType::TextNote && $note->isEditor()){
                    echo '<a href="EditText/note/'. $note->getId() .'" class="icon-link">';
                    echo ' <span class="material-symbols-outlined"> edit </span>';
                    echo '</a>';
                }elseif($note->getType() == NoteType::ChecklistNote && $note->isEditor()){
                    echo '<a href="Checklistnote/edit_checklistnote/'. $note->getId() .'" class="icon-link">';
                    echo ' <span class="material-symbols-outlined"> edit </span>';
                    echo '</a>';
                }

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
                echo '<a  href="Share/note/'. $note->getId() .'" class="icon-link">';
                echo ' <span  class="material-symbols-outlined"> share </span>';
                echo '</a>';
                // pinned
                echo $note->isPinned() ? '<a href="index/unpin/' . $note->getId() . '" class="icon-link"><span style="font-variation-settings: \'FILL\' 1, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24;" class="material-symbols-outlined"> push_pin </span></a>' : '<a href="index/pin/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> push_pin </span></a>';

                // archived
                echo $note->isArchived() ? '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> unarchive </span> </a>' : '<a href="index/archive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> archive </span></a>';

                if ($note->getType() == NoteType::TextNote){
                    echo '<a href="EditText/note/'. $note->getId() .'" class="icon-link">';
                    echo ' <span class="material-symbols-outlined"> edit </span>';
                    echo '</a>';
                }else{
                    echo '<a href="Checklistnote/edit_checklistnote/'. $note->getId() .'" class="icon-link">';
                    echo ' <span class="material-symbols-outlined"> edit </span>';
                    echo '</a>';
                }

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


<!-- Modal pour la suppression -->
<div class="modal fade" id="confirmDeleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirmation de la suppression</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette note ?
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <a href="delete/note/<?php echo $note->getId(); ?>" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>
