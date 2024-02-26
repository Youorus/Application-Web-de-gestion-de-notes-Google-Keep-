<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

<?php
include "utils/navbar.php";
?>

<div class="container">
    <?php
    if (empty($notesPinned) || empty($notesOthers)){
        echo '<h5 class="infoText"> notes is empty. </h5>';
    }else{
       echo '<h3>Pinned</h3>';
   echo '<div class="row">';

       include "pinnedNote.php";
echo '</div>';
echo '<br>';
echo '<h3>Others</h3>';
echo '<div class="row">';
    include "othersNote.php";
echo '</div>';
    }
    ?>

</div>


<div class="fixed-icons">
    <a href="#"> <i class="fa-regular fa-file"> </i></a>
    <a href="index/add_checklistnote"> <i class="fa-solid fa-list-check"></i></a>

</div>

</body>
</html>