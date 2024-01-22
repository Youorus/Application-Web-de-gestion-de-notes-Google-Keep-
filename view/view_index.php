<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes</title>
    <base href="<?= $web_root ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript et Popper.js (nécessaire pour les fonctionnalités de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
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
    <a href="#"> <i class="fa-solid fa-list-check"></i></a>

</div>

</body>
</html>