<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="css/style.css">


  <style>
        .mb-3{
            margin: 4% 5% 0 5%;
        }
        .infoText{
            font-style: italic;
            font-weight: normal;
            font-size: initial;
            margin-bottom: 2%;
            margin-left: 1%;
        }
        .form-label{
            font-size: larger;
        }
        .form-control {
            background-color: var(--couleur-bordure) !important;
            color: white;
            border-color: var(--couleur-bordure);
        }
        .form-control:focus{
            color: white;
        }
        .material-icons{
            color: white;
        }

    </style>
</head>

<div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <a href="index/index.php">
                    <i class="material-icons">
                        <span class="material-symbols-outlined">
                            arrow_back_ios 
                        </span>
                    </i>
                </a>    
                <i class="material-icons" style="margin-left: auto;">
                <form action="path/to/controller_method.php" method="post">
                <button type="submit" class="material-icons" style="background:none; border:none;">
                    <span class="material-symbols-outlined">
                        save_as
                    </span>
                </form>     
                </i>

            </div>   

            <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" >

        </div>

        <div class="mb-3">
            <label for="Text" class="form-label">Text</label>
            <textarea class="form-control" id="Text" rows="8"></textarea>
        </div>
    </body>

</html>    