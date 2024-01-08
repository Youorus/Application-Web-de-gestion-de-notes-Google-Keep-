<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  
</head>
    <body>
     
       
        <!-- menu deroulant -->
            <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                <span class="material-symbols-outlined">
                    arrow_back_ios
                </span>
                <h2 class="offcanvas-title text" id="offcanvasDarkNavbarLabel"><?php
               echo  $title 
                 ?>
                 </h2>
                
                </div>
                <!-- corps de la liste deroulante  -->
                <div class="offcanvas-body ">
                   <div class="message utilisateur">
                        <p>Hey <?php echo $user_name ?>  </p> <!--ajouter user -->
                   </div>       
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="material-symbols-outlined">
                                    manage_accounts
                                </span> Edit profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="material-symbols-outlined">
                                    password
                                </span> Change password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="material-symbols-outlined">
                                    logout
                                <?php echo $logout ?>
                                </span> Logout
                            </a>
                        </li>
                    </ul>
                </div>
        </div>
    

    </body>     
</html> 
   