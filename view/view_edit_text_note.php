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
<!--    <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">-->
<!--            <div class="offcanvas-header">-->
<!--                <a href="index/index.php">-->
<!--                    <i class="material-icons">-->
<!--                    <span class="material-symbols-outlined">-->
<!--                        arrow_back_ios-->
<!--                    </span>-->
<!--                    </i>-->
<!--                </a>-->
<!--                <i class="material-icons" style="margin-left: auto;">-->
<!--                <form action="path/to/controller_method.php" method="post">-->
<!--                <button type="submit" class="material-icons" style="background:none; border:none;">-->
<!--                    <span class="material-symbols-outlined">-->
<!--                        save_as-->
<!--                    </span>-->
<!--                </form>-->
<!--                </i>-->
<!---->
<!--            </div>-->

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


