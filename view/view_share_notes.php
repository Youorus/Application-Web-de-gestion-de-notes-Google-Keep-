<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

<?php
include "utils/navbar.php";
?>

<div class="note-container">
    <?php
    include "displayNoteCardView.php";

    for ($i = 0; $i < count($notesShares); $i++) {
        echo '<div class="col-md-4">';
        echo '<div class="card-other">';
        displayNoteCardView($notesShares[$i]);
        echo '</div>';
        echo '</div>';
    }
    ?>

    </div>

</div>
</body>
</html>
