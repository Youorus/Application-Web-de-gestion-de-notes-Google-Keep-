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
                echo '<form class="formDelete icon-link" action="delete" method="post">';
                echo ' <input type="hidden" id="id_item" name="idNote" value="' . $note->getId() . '" >';
                echo ' <button id="deleteModal"  data-bs-toggle="modal" data-bs-target="#myModalDelete" style="font-variation-settings: \'FILL\' 0, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24; color: #FF0000;" class="material-symbols-outlined delete-icon"> delete_forever </button>';
                echo '</form>';
                // unarchived
                echo '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined">unarchive</span></a>';
            } elseif ($noteType == "share"){
                // edite share
                if ($note->getType() == NoteType::TextNote && $note->isEditor() || $note->getType() == NoteType::ChecklistNote && $note->isEditor() ){
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
                        echo '<a href="Checklistnote/editchecklistnote/'. $note->getId() .'" class="icon-link">';
                        echo ' <span class="material-symbols-outlined"> edit </span>';
                        echo '</a>';
                    }
                }else{
                    // share
                    echo '<a  href="Share/note/'. $note->getId() .'" class="icon-link">';
                    echo ' <span  class="material-symbols-outlined"> share </span>';
                    echo '</a>';
                    // pinned
                    echo $note->isPinned() ? '<a href="index/unpin/' . $note->getId() . '" class="icon-link"><span style="font-variation-settings: \'FILL\' 1, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24;" class="material-symbols-outlined"> push_pin </span></a>' : '<a href="index/pin/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> push_pin </span></a>';

                    // archived
                    echo $note->isArchived() ? '<a href="index/unarchive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> unarchive </span> </a>' : '<a href="index/archive/' . $note->getId() . '" class="icon-link"><span class="material-symbols-outlined"> archive </span></a>';

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
                    echo '<a href="Checklistnote/editchecklistnote/'. $note->getId() .'" class="icon-link">';
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
<div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="custom-modal  modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Are you sure?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>

            <!-- Modal Body -->
            <div class="modal-body">
                <span>Do you really want to delete note <span class="text-danger">"<?= $title ?></span> and All Its dependencies ?</span>
                <br>
                <br>
                <span>This process can not be undone.</span>


            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <!-- Utilisation de PHP pour inclure la variable $idNote dans les liens -->
                <a class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</a>
                <a class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Yes,delete it!</a>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" custom-modal modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Deleted</h1>
            </div>
            <div class="modal-body">
                This note has been deleted.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="delete" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const idNote = <?= $note->getId()?>;
    let deleteButton = $("#deleteModal");
    let deleteClose = $("#delete");


    async function deleteNote() {
        await $.get("delete/validate/" + idNote);
        window.location.href = "index";
    }

    deleteClose.bind("click", deleteNote);

    deleteButton.click(function(event) {
        // Empêche la redirection par défaut
        event.preventDefault();
        // Affiche le modal
        $("#myModalDelete").modal("show");
    });





</script>
