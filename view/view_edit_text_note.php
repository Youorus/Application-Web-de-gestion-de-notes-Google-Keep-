<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<script>
    const minLenght = <?= $minLenght ?>;
    const maxLenght = <?= $maxLenght ?>;
</script>

<form id="EditTextNote" method="POST" action="EditText/edited_note/<?= $note->getId() ?>" >

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
            <button class="bt-default" type="submit" form="EditTextNote">
                <span class="material-symbols-outlined">save</span>
            </button>
        </div>
    </div>
</div>

<!--<div>-->
<!--    --><?php
//        echo '<h5 class="infoText"> Created ' . $messageCreate . '. Edited ' . $messageEdit . ' </h5>';
//    ?>
<!---->
<!--</div>-->



    <div class="open-text">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="title_note" class="form-control" value="<?= $title ?>" name="title_note">
            <h2 class="error-text" id="titleError"></h2>
            <!-- Section pour afficher les erreurs -->
            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <h2 class="error-text"><?php echo $error; ?></h2>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Text</label>
            <textarea class="form-control" id="content_note" value="<?= $content ?>" rows="10" name="content_note"></textarea>
            <h2 class="error-text" id="contentError"></h2>

        </div>
    </div>
</form>

<script src="scripts/text_note_validate.js"></script>

</body>
</html>
