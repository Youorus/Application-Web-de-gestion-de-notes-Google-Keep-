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
        <?php foreach ($content as $index => $item): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="Checklistnote/check_uncheck" method="post" class="flex-grow-1 me-2">
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="checked" value="1" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" disabled>
                        </div>
                        <input type="text" class="form-control item-content" value="<?= htmlspecialchars($item->getContent()); ?>" aria-label="Text input with checkbox">
                        <input type="hidden" class="item-id" name="item_id[]" value="<?= $item->getId(); ?>">
                    </div>
                </form>
                <form action="Checklistnote/delete_item" method="post">
                    <input type="hidden" class="item-id" name="id_item" value="<?= $item->getId(); ?>">
                    <button class="btn delete-btn" type="submit" aria-label="Delete">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </form>
            </div>
             <!-- Class instead of ID for error message -->
        <?php endforeach; ?>
        <?php if($coderror == 2) {
            echo "$msgerror";

        } ?>
        <div class="my-3">
            <label class="form-label">New Items</label>
            <div class="d-flex justify-content-between align-items-center">
                <form action="Checklistnote/add_item" method="post" class="flex-grow-1 me-2">
                    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
                    <h2 class="error-text item-error"></h2>
                    <div class="input-group">

                        <input type="text" id="content" name="content" class="form-control" placeholder="New Item" aria-label="New item input" >
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


<script>
    $(function () {
        let titleInput = $("#title");
        let titleError = $("#titleError");
        let itemInputs = $("#content"); // Utilise la classe au lieu de l'ID
        let itemErrors = $(".item-error"); // Utilise la classe pour les messages d'erreur

        // Les valeurs de configuration
        const minLength = <?= $minLength ?>;
        const maxLength = <?= $maxLength ?>;
        const minItemLength = <?= $minItemLength ?>;
        const maxItemLength = <?= $maxItemLength ?>;

        function checkTitle() {
            let titleLength = titleInput.val().trim().length;
            titleError.text("");
            if (titleLength < minLength) {
                titleError.text("The title must have more than " + minLength + " characters");
            } else if (titleLength > maxLength) {
                titleError.text("The title must have less than " + maxLength + " characters");
            }
        }

        function checkItems() {
            itemInputs.each(function(index) {
                let itemInput = $(this);
                let itemValue = itemInput.val().trim();
                let itemError = itemErrors.eq(index); // Sélectionne le message d'erreur correspondant
                itemError.text("");
                if (itemValue.length < minItemLength) {
                    itemError.text("Item must have at least " + minItemLength + " characters.");
                } else if (itemValue.length > maxItemLength) {
                    itemError.text("Item must have less than " + maxItemLength + " characters.");
                }
            });
        }

        titleInput.on("input", checkTitle);
        itemInputs.on("input", checkItems); // Attache l'événement à chaque input d'item
    });
</script>



</body>
</html>
