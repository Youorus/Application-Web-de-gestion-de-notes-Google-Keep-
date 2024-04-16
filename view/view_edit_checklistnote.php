<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>


<div class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Bouton de retour -->
        <div class="navbar-icon">
            <a href="index">
                <span class="material-symbols-outlined"> arrow_back_ios </span>
            </a>
        </div>

        <!-- Bouton quelconque -->
        <div class="navbar-icons">
            <!-- save bouton -->
            <button class="bt-default" type="submit" form="editchecklistnote">
                <span class="material-symbols-outlined">save</span>
            </button>
        </div>
    </div>
</div>


<form name="editchecklistnote" id="editchecklistnote" action="Checklistnote/editchecklistnote" method="post">
<div class="open-text">
    <label class="form-label">Title</label>
    <input id="title" name="title" type="text" class="form-control"  value="<?= $title ?>">
    <h2 class="error-text" id="titleError"></h2>

    <?php if($coderror == 1) {
        echo "$msgerror";
    } ?>

    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
</form>
    <div class="checklist-items">
        <label class="form-label">Items</label>
        <script> console.log("hello")</script>
        <?php foreach ($content as $item): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="Checklistnote/check_uncheck" method="post" class="flex-grow-1 me-2">
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="checked" value="1" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" disabled>
                        </div>
                        <input type="text" id="itemcontent" class="form-control item-content" value="<?= htmlspecialchars($item->getContent()); ?>" aria-label="Text input with checkbox">
                        <input type="hidden" id="item_id" name="item_id" value="<?= $item->getId(); ?>">
                    </div>
                </form>
                <form action="Checklistnote/delete_item" method="post">
                    <input type="hidden" id="id_item" name="id_item" value="<?= $item->getId(); ?>">
                    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
                    <button class="btn delete-btn" type="submit" aria-label="Delete">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </form>
            </div>
            <h2 class="error-text" id="itemError"></h2>
        <?php endforeach; ?>
        <?php if($coderror == 2) {
            echo "$msgerror";

        } ?>
        <div class="my-3">
            <label class="form-label">New Items</label>
            <div class="d-flex justify-content-between align-items-center">
                <form action="Checklistnote/add_item" method="post" class="flex-grow-1 me-2">
                    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="New Item" aria-label="New item input" >
                        <button class="btn add-btn" type="submit" aria-label="Add">
                            <i class="bi bi-plus-lg"></i>
                            <input type="hidden" id="id_item" name="id_item" value="<?= $item->getId(); ?>">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="scripts/checklist_note_validate.js"></script>


<script>

        var config = {
        itemMinLength: <?= ini_get('item_min_length') ?>,
        itemMaxLength: <?= ini_get('item_max_length') ?>,
        titleMinLength: <?= ini_get('title_min_lenght') ?>,
        titleMaxLength: <?= ini_get('title_max_lenght') ?>
        };

</script>
<script>
    /*
    $(document).ready(function() {
        let titleInput = $("#title");
        let titleError = $("#titleError");

        function checkTitleLength() {
            let titleLength = titleInput.val().trim().length;
            if (titleLength < 3) {
                titleError.text("Le titre doit contenir au moins 3 caractères.");
            } else {
                titleError.empty(); // Utilisez .empty() pour effacer le contenu
            }
<<<<<<< HEAD

        },
        // On définit ici les messages d'erreur propre à chaque champ
        messages: {
            title: "title must be between 3 and 25"
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "Checklistnote/editchecklistnote", // on envoie le tout dans la moulinette php du fichier form-process.php pour l'envoi du message
                data: "title=" + title,
                success : function(text){
                    if (text == "success"){ //si c'est ok, applique la fonction formSuccess
                        formSuccess();
                    }
                }
            });
=======
>>>>>>> daac007c2b88a72714d6cbd3e8f606162b2c09f6
        }

        titleInput.on("input", checkTitleLength);
    });

     */
</script>


</body>
</html>
