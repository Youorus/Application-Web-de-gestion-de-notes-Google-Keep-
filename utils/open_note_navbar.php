<nav class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Première div avec l'icône de retour -->
        <div class="navbar-icon">
            <a href="#">
                <i class="fas fa-arrow-left fs-1"></i>
            </a>
        </div>

        <!-- Deuxième div avec quatre autres icônes -->
        <div class="navbar-icons">
            <?php
            if ($noteType == "archived"){
                //delete
            echo '<a href="#">';
            echo ' <i class="fa-solid fa-calendar-xmark"></i>';
            echo '</a>';
            //unarchived
                echo '<a href="#">';
                echo '<i class="fa-solid fa-arrow-up-from-ground-water"></i> ';
                echo '</a>';
            }elseif ($noteType == "shared"){
                // edite share
                echo '<a href="#">';
                echo ' <i class="fa-regular fa-pen-to-square"></i>';
                echo '</a>';
            }else{
                //share
                echo '<a href="index/view-share">';
                echo '  <i class="fa-solid fa-share-nodes"></i>';
                echo '</a>';
                //pinned
                echo $note->ispinned() ? '<a href="index/unpin/' . $note->getId() . '"><i class="fa-solid fa-thumbtack"></i></a>' : '<a href="index/pin"><i class="fa-solid fa-thumbtack"></i></a>';

                //archived
                echo '<a href="#">';
                echo ' <i class="fa-solid fa-box-archive"></i>';
                echo '</a>';
                //edited
                echo '<a href="#">';
                echo ' <i class="fa-regular fa-pen-to-square"></i>';
                echo '</a>';
            }
            ?>


        </div>
    </div>
</nav>