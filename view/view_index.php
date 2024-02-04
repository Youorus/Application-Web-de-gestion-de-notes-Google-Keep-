<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

<?php
include "utils/navbar.php";
?>

<div class="container">
    <h3>Pinned</h3>
    <div class="row">
       <?php
       include "pinnedNote.php";
       ?>
    </div>
    <br>
    <h3>Others</h3>
    <div class="row">
        <?php
        include "othersNote.php";
        ?>
    </div>
</div>


<div class="fixed-icons">
    <a href="#"> <i class="fa-regular fa-file"> </i></a>
    <a href="index/add_checklistnote"> <i class="fa-solid fa-list-check"></i></a>

</div>

</body>
</html>