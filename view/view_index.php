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
    <style>

        body{
            background-color: var(--couleur-fond);
        }
        .form-check{
            margin: 3%;
        }
        .card-text{
            padding: 3%;
        }
        .card-body{
            padding: 0;
        }
        .card-title{
            padding: 3%;
        }

        .bord {
            border-width: 0 0 1px 0;
            border-color: var(--couleur-bordure);
            border-style: solid;
        }

        .card {
            background-color: var(--couleur-fond);
            border: 1px solid var(--couleur-bordure);
            border-bottom: none;
        }
        .iconBox{
            border-top: 1px solid var(--couleur-bordure);
            border-bottom: 1px solid var(--couleur-bordure);
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .iconBox span i{
            color: var(--couleur-bouton);
        }

        .offcanvas-start {
            width: 220px;
        }
        .fixed-icons {
            position: fixed;
            top: 80%;
            right: 5%;
        }

        .fixed-icons i {
            font-size: 40px;
            margin: 10px;
            color: var(--couleur-icon);
        }
    </style>
</head>
<body>

<?php
include "utils/navbar.php";
?>

<div class="container">
    <h3>Pinned</h3>
    <div class="row">
       <?php
       include "utils/pinnedNote.php";
       ?>
    </div>
    <br>
    <h3>Others</h3>
    <div class="row">
        <?php
        include "utils/othersNote.php";
        ?>
    </div>
</div>


<div class="fixed-icons">
    <a href="#"> <i class="fa-regular fa-file"> </i></a>
    <a href="#"> <i class="fa-solid fa-list-check"></i></a>

</div>

</body>
</html>