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
<!--    <link rel="stylesheet" href="css/style.css">-->
    <style>
        .card-body{
            padding: 0;
        }

        .bord {
            border-width: 0 0 1px 0;
            border-color: black;
            border-style: solid;
        }

        .card {
            border: 1px solid black;
            border-bottom-left-radius: initial;
            border-bottom-right-radius: initial;
        }
        .iconBox{
            margin-bottom: 4%;
            border: 1px solid black;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            border-top: none;
        }

        .offcanvas-start {
            width: 220px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed">
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
$notes_pinned = [];
$notes_others = [];
for ($i = 0; $i < count($notes); $i++) {
    if ($notes[$i]->getPinned() == 1){
        $notes_pinned [] = $notes[$i];
    }else{
        $notes_others[] = $notes[$i];
    }
}
?>

<div class="container">
    <h3>Pinned</h3>
    <div class="row">
        <?php
        for ($i = 0; $i < count($notes_pinned); $i++) {
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title bord">' . $notes_pinned[$i]->getTitle() . '</h5>';
            $found = false;

            foreach ($notes_content as $content) {
                if ($content->getId() == $notes_pinned[$i]->getId()) {
                    $found = true;

                    if ($content->getContent() === null) {
                        echo '<p class="card-text">' . 'Note vide' . '</p>';
                    } else {
                        $length_string = strlen($content->getContent());

                        if ($length_string > 80) {
                            $tmp_string = "";
                            for ($j = 0; $j < $length_string; $j++) {
                                $tmp_string .= $content->getContent()[$j];
                                if ($j == 80){
                                    break;
                                }
                            }
                            echo $tmp_string  ."...";
                            break; // Si une correspondance est trouvée, sortir de la boucle
                        } else {
                            echo '<p class="card-text">' . $content->getContent() . '</p>';
                        }
                    }
                }
            }

            if (!$found) {
                $counter = 0;
                foreach ($checklist_Note as $checkNote) {
                    if ($checkNote->getChecklistNote() == $notes_pinned[$i]->getId()) {
                        echo '<div class="form-check">';
                        echo '  <input class="form-check-input" type="checkbox" value="1" id="exampleCheckbox" name="exampleCheckbox" ' . ($checkNote->getChecked() == 1 ? 'checked' : '') . '>';
                        echo '  <label class="form-check-label" for="exampleCheckbox">';
                        echo $checkNote->getContent();
                        echo '  </label>';
                        echo '</div>';

                        $counter++;

                        if ($counter == 3) {
                            echo '...';
                            break;
                        }
                    }
                }
            }

            echo '</div>';
            echo '</div>';
            // Ajoutez vos icônes à l'intérieur de la card
            echo '<div class="d-flex iconBox justify-content-between">';
            echo '<span><i class="fa-solid fa-angles-left"></i></span>';
            echo '<span><i class="fa-solid fa-angles-right"></i></span>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
</div>

<br>


<div class="container">
    <h3>Others</h3>
    <div class="row">
        <?php
        for ($i = 0; $i < count($notes_others); $i++) {
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title bord">' . $notes_others[$i]->getTitle() . '</h5>';
            $found = false;

            foreach ($notes_content as $content) {
                if ($content->getId() == $notes_others[$i]->getId()) {
                    $found = true;

                    if ($content->getContent() === null) {
                        echo '<p class="card-text">' . 'Note vide' . '</p>';
                    } else {
                        $length_string = strlen($content->getContent());

                        if ($length_string > 80) {
                            $tmp_string = "";
                            for ($j = 0; $j < $length_string; $j++) {
                                $tmp_string .= $content->getContent()[$j];
                                if ($j == 80){
                                    break;
                                }
                            }
                            echo $tmp_string  ."...";
                            break; // Si une correspondance est trouvée, sortir de la boucle
                        } else {
                            echo '<p class="card-text">' . $content->getContent() . '</p>';
                        }
                    }
                }
            }

            if (!$found) {
                $counter = 0;
                foreach ($checklist_Note as $checkNote) {
                    if ($checkNote->getChecklistNote() == $notes_others[$i]->getId()) {
                        echo '<div class="form-check">';
                        echo '  <input class="form-check-input" type="checkbox" value="1" id="exampleCheckbox" name="exampleCheckbox" ' . ($checkNote->getChecked() == 1 ? 'checked' : '') . '>';
                        echo '  <label class="form-check-label" for="exampleCheckbox">';
                        echo $checkNote->getContent();
                        echo '  </label>';
                        echo '</div>';

                        $counter++;

                        if ($counter == 3) {
                            echo '...';
                            break;
                        }
                    }
                }
            }

            echo '</div>';
            echo '</div>';
            // Ajoutez vos icônes à l'intérieur de la card
            echo '<div class="d-flex iconBox justify-content-between">';
            echo '<span><i class="fa-solid fa-angles-left"></i></span>';
            echo '<span><i class="fa-solid fa-angles-right"></i></span>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
</div>
</body>
</html>