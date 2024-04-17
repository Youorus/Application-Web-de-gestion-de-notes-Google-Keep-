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
        <?php foreach ($content as $item): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="Checklistnote/check_uncheck" method="post" class="flex-grow-1 me-2">
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="checked" value="1" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" disabled>
                        </div>
                        <input type="text"  class="form-control item-content" value="<?= htmlspecialchars($item->getContent()); ?>" aria-label="Text input with checkbox">
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
            <h2 class="error-text item-error"> </h2>
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
        // Configuration des sélecteurs
        let titleInput = $("#title");
        let titleError = $("#titleError");
        let itemInput = $("#itemcontent"); // Assurez-vous que cet ID est unique ou utilisez une classe si plusieurs inputs.
        let itemError = $("#itemError");

        // Les valeurs de configuration devraient être injectées dans la vue et disponibles ici
        const minLength = <?= $minLength ?>; // Assurez-vous que ces valeurs sont correctement injectées
        const maxLength = <?= $maxLength ?>;
        const minItemLength = <?= $minItemLength ?>;
        const maxItemLength = <?= $maxItemLength ?>;

        // Fonction pour vérifier la longueur du titre
        function checkTitle() {
            let titleLength = titleInput.val().trim().length;
            if (titleLength < minLength) {
                titleError.text("The title must have more than " + minLength + " characters");
            } else if (titleLength > maxLength) {
                titleError.text("The title must have less than " + maxLength + " characters");
            } else {
                titleError.text(""); // Effacer le texte d'erreur si la condition est satisfaite
            }
        }

        // Fonction pour vérifier la longueur et l'unicité de l'item
        function checkItem() {
            let itemValue = itemInput.val().trim();
            if (itemValue.length < minItemLength) {
                itemError.text("Item must have at least " + minItemLength + " characters.");
                return;
            } else if (itemValue.length > maxItemLength) {
                itemError.text("Item must have less than " + maxItemLength + " characters.");
                return;
            }

            // Collecte et vérification de l'unicité des items
            let itemsArray = collectItems();
            if (itemsArray.includes(itemValue)) {
                itemError.text("Il ne peut pas y avoir 2 items ou plus du même nom.");
            } else {
                console.log("L'item peut être ajouté."); // Pour le débogage
                itemError.text(""); // Effacer l'erreur
            }
        }

        // Collecter les valeurs des items existants
        function collectItems() {
            let items = [];
            $('.item-content').each(function () {
                let value = $(this).val().trim();
                if (value) items.push(value);
            });
            return items;
        }

        // Attachement des gestionnaires d'événements
        titleInput.on("input", checkTitle);
        itemInput.on("input", checkItem);
    });

</script>


</body>
</html>
