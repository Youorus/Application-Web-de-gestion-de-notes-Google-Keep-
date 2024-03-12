<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

<nav class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Bouton de retour -->
        <div class="navbar-icon">
            <a href="index/archive_notes">
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

<form id="addTextNote" method="POST" action="votre_action.php">
    <div class="open-text">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="mb-3">
            <label class="form-label">Text</label>
            <textarea class="form-control" rows="10" name="text"></textarea>
        </div>
    </div>
</form>

</body>
</html>
