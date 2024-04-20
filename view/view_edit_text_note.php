<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<script>
    const minLenght = <?= $minLenght ?>;
    const maxLenght = <?= $maxLenght ?>;
    const title = "<?= $title ?>";
    const content = "<?= $content ?>"
</script>

<form id="EditTextNote" method="POST" action="EditText/edited_note/<?= $note->getId() ?>" >

<div class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Bouton de retour -->
        <div class="navbar-icon">
            <a id="back" type="button" data-bs-toggle="modal" data-bs-target="#myModalSave">
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
            <textarea class="form-control" id="content_note" rows="10" name="content_note"><?= $content ?></textarea>
            <h2 class="error-text" id="contentError"></h2>

        </div>
    </div>
</form>


<div class="modal fade" id="myModalSave">
    <div class="modal-dialog modal-dialog-centered">
        <div class="custom-modal modal-content">

            <!-- Modal Header -->
            <div class="bg-back modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="bg-back modal-body">
                <span>Are you sure you want to leave this form </span> ?
                <br>
                <br>
                <span>Change you made will not be saved </span> ?


            </div>

            <!-- Modal Footer -->
            <div class=" bg-back modal-footer">
                <!-- Utilisation de PHP pour inclure la variable $idNote dans les liens -->
                <a class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</a>
                <a class="btn btn-danger" href="index" >Leave Page</a>
            </div>

        </div>
    </div>
</div>



<script src="scripts/text_note_validate.js"></script>

</body>
</html>
