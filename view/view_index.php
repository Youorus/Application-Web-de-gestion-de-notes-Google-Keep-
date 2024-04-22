<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

<?php
include "utils/navbar.php";
?>

<div class="container">
    <?php
    if (empty($notesPinned) && empty($notesOthers)) {
        echo '<h5 class="infoText">Notes are empty.</h5>';
    } elseif (empty($notesPinned)) {
        echo '<h5 class="infoText">Pinned notes are empty.</h5>';
        echo '<h3>Others</h3>';
        echo '<div class="custom">';
        include "othersNote.php";
        echo '</div>';
    } elseif (empty($notesOthers)) {
        echo '<h3>Pinned</h3>';
        echo '<div class="custom">';
        include "pinnedNote.php";
        echo '</div>';
        echo '<h5 class="infoText">Other notes are empty.</h5>';
    } else {
        echo '<h3>Pinned</h3>';
        echo '<div class="custom">';
        include "pinnedNote.php";
        echo '</div>';
        echo '<br>';
        echo '<h3>Others</h3>';
        echo '<div class="custom">';
        include "othersNote.php";
        echo '</div>';
    }
    ?>


</div>

<div class="fixed-icons">
    <a href="AddTextNote"> <i class="fa-regular fa-file"> </i></a>
    <a href="Checklistnote/form"> <i class="fa-solid fa-list-check"></i></a>

</div>

</body>
</html>