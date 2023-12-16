<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <base href="<?= $web_root ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript et Popper.js (nécessaire pour les fonctionnalités de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body{
            margin-top: 5%;
            margin-bottom: 5%;
        }
        .iconBox{
            border: 1px solid black;
            border-top: none;
        }

        .offcanvas-start {
            width: 220px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">My notes</a>
        <!-- menu deroulant -->
        <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark" tabindex="-5" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title text-warning" id="offcanvasDarkNavbarLabel">NoteApp</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- corps de la liste deroulante  -->
            <div class="offcanvas-body ">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link moi" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<?php
//// Vérifier si $notes est différent de null avant d'itérer
//if ($notes !== null) {
//    foreach ($notes as $note):
//        ?>
<!--        <p>--><?php //= $note->getTitle() ?><!--</p>-->
<!--    --><?php
//    endforeach;
//} else {
//    // Traitement en cas de null
//    echo "La variable \$notes est null.";
//}
//?>

<?php
//// Vérifier si $notes est différent de null avant d'itérer
//if ($notes_content !== null) {
//    foreach ($notes_content  as $content):
//        ?>
<!--        --><?php //= $content->getContent() ?>
<!--    --><?php
//    endforeach;
//} else {
//    // Traitement en cas de null
//    echo "La variable \$notes est null.";
//}
//?>



<div class="container">
    <div class="row">
        <?php
        for ($i = 0; $i < count($notes); $i++) {
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<div class="c   ard-body">';
            echo '<h5 class="card-title">' . $notes[$i]->getTitle() . '</h5>';

            $found = false;
            foreach ($notes_content as $content) {
                if ($content->getId() == $notes[$i]->getId()) {
                    $found = true;
                    echo '<p class="card-text">' . ($content->getContent() !== null ? $content->getContent() : 'Note vide') . '</p>';
                    break; // Si une correspondance est trouvée, sortir de la boucle
                }
            }

            if (!$found) {
                foreach ($checklist_Note as $checkNote) {
                    if ($checkNote->getChecklistNote() == $notes[$i]->getId()) {
                        echo '<p class="card-text">' . $checkNote->getContent() . '</p>';

                    }
                }
            }

            echo '</div>';
            echo '</div>';
            // Ajoutez vos icônes à l'intérieur de la card
            echo '<div class="d-flex iconBox justify-content-between">';
            echo '<span><i class="fa-solid fa-angles-left"></i></span>';
            echo '<span><i class="fa-solid fa-angles-left"></i></span>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
</body>
</html>