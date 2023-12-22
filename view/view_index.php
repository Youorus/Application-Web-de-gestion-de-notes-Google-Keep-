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





<div class="container">
    <h3>Pinned</h3>
    <div class="row">
        <?php
        for ($i = 0; $i < count($notesPinned); $i++) {
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title bord">' . $notesPinned[$i]->getTitle() . '</h5>';

          if ($notesPinned[$i]->getType() == NoteType::TextNote) {
                if ($notesPinned[$i]->getContent() === null) {
                    echo '<p class="card-text">' . 'Note vide' . '</p>';
                }else {
                    $length_string = strlen($notesPinned[$i]->getContent());
                    if ($length_string > 80) {
                        $tmp_string = "";
                        for ($j = 0; $j < $length_string; $j++) {
                            $tmp_string .= $notesPinned[$i]->getContent()[$j];
                            if ($j == 80) {
                                break;
                            }
                        }
                       echo '<p class="card-text">' . $tmp_string . "..." . '</p>';
                    } else {
                        echo '<p class="card-text">' . $notesPinned[$i]->getContent() . '</p>';
                    }
                }
               }else{
              $items = $notesPinned[$i]->getItems();
              foreach ($items as $item) {
                  echo '<div class="form-check">';
               echo '  <input class="form-check-input" type="checkbox" value="1" id="exampleCheckbox" name="exampleCheckbox" ' . ($item ->getChecked() == 1 ? 'checked' : '') . '>';
                echo '  <label class="form-check-label" for="exampleCheckbox">';
               echo $item->getContent();
               echo '  </label>';
                echo '</div>';
              }
              }

            echo '</div>';
            echo '<div class="d-flex iconBox justify-content-between">';
            echo '<span><i class="fa-solid fa-angles-left"></i></span>';
            echo '<span><i class="fa-solid fa-angles-right"></i></span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

        }

        ?>
    </div>
</div>


</body>
</html>