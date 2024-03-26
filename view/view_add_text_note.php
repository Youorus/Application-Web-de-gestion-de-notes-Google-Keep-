<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>

<script>
    let title_note, titleError, content_note, contentError;


    //je recupere les valeur de mes input en js et je reste focus a mes entré de text
    $(function (){
        title_note = $("#title_note");
        titleError = $("#titleError");
        content_note = $("#content_note");
        contentError = $("#contentError");

        title_note.bind("input", checkTitle);

        $("input:text:first").focus();
    })

    function checkTitle(){
        titleError.text("");
        if (title_note.val().length < 3 )
            titleError.text("The title must have more than 3 characters");
        if (title_note.val().length > 25)
            titleError.text("The title must have less than 25 characters");
    }

    async  function checkTitle(){

        const data = await $.getJSON("addtextnote/validate/" + title_note.val())
        if (data){
            titleError.text("this title is already exist");
        }


</script>


<body>

<form id="addTextNote" method="POST" action="AddTextNote/add_text_note">

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


    <div class="open-text">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="title_note" class="form-control" value="<?= isset($title_note) ? $title_note : '' ?>" name="title_note">
            <h2 class="error-text" id="titleError"></h2>
            <!-- Section pour afficher les erreurs -->
            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <h2 class="error-text" ><?php echo $error; ?></h2>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Text</label>
            <textarea class="form-control" id="content_note" value="<?= isset($content_note) ? $content_note : '' ?>" rows="10" name="content_note"></textarea>
            <h2 class="error-text" id="contentError"></h2>
        </div>
    </div>
</form>

<!-- Styles pour les messages d'erreur -->
<style>
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
</style>

</body>
</html>
