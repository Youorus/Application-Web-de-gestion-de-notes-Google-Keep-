<!DOCTYPE html>
<html lang="en">

<?php include "head.php"?>
    <body>
     
       
        <!-- menu deroulant -->
            <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                <a href="index/index">
                    <i class="material-icons">
                    <span class="material-symbols-outlined">
                        arrow_back_ios 
                    </span>
                    </i>
                </a>
                
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
                            <a class="nav-link" href="login">
                                <span class="material-symbols-outlined">
                                    logout
                                
                                </span> Logout
                            </a>
                        </li>
                    </ul>
                </div>
        </div>
    

    </body>     
</html> 
   