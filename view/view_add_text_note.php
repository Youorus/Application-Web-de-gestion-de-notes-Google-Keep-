<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

<nav class="navbar navbar-dark bg-dark fixed">
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
</nav>

<form id="addTextNote" method="POST" action="AddTextNote/add_text_note">
    <div class="open-text">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="title_note" class="form-control" value="<?= isset($title_note) ? $title_note : '' ?>" name="title_note">
            <!-- Section pour afficher les erreurs -->
            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <h2 class="error-text"><?php echo $error; ?></h2>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Text</label>
            <textarea class="form-control" id="content_note" value="<?= isset($content_note) ? $content_note : '' ?>" rows="10" name="content_note"></textarea>

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
