<!DOCTYPE html>
<html lang="en">

<?php include "head.php"?>
    <body>

        <?php include "utils/open_note_navbar.php"?>

        <div class=" open-text">
            <div class="mb-3">
                <label  class="form-label">Title</label>
                <input type="text" class="form-control" value="<?= $title ?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">Text</label>
                <textarea class="form-control" rows="10" > <?= $content == null? "Note Vide": $content ?> </textarea>
            </div>
        </div>
    </body>

</html>    


