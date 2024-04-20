<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>

<script>
    const minLenght = <?= $minLenght ?>;
    const maxLenght = <?= $maxLenght ?>;
</script>


<body>



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
            <button class="bt-default" type="submit" form="addTextNote">
                <span class="material-symbols-outlined">save</span>
            </button>
        </div>
    </div>
</div>

<form id="addTextNote" method="POST" action="addTextNote">

    <div class="open-text">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="title_note" class="form-control" value="<?= trim($title_note) ?>" name="title_note">
            <h2 class="error-text" id="titleError"></h2>
            <!-- Section pour afficher les erreurs -->
            <?php if (count($errors) != 0): ?>
                <?php foreach ($errors as $error): ?>
                    <?php if (is_string($error)): ?>
                        <h2 class="error-text"><?= $error ?></h2>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Text</label>
            <textarea class="form-control" id="content_note" value="<?= $content_note ?>" rows="10" name="content_note"></textarea>
            <h2 class="error-text" id="contentError"></h2>
        </div>
    </div>
</form>



<script src="scripts/text_note_validate.js"></script>

</body>
</html>
