<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
    <body>
        <div class = "offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" ></div>
        
            <div class="offcanvas-header">
            <i class="material-icons">arrow_back_ios</i>

                <h2 class="offcanvas-title text" id="offcanvasDarkNavbarLabel">
                    <?php
                        echo  $title; 
                    ?>
                </h2>
            </div>    
            
        </div>
    </body>
</html>                