<nav class="navbar navbar-dark bg-dark fixed">
    <div class="container">
        <!-- Première div avec l'icône de retour -->
        <div class="navbar-icon">
            <a href="index/index">
                <i class="fas fa-arrow-left fs-1"></i>
            </a>
        </div>

        <!-- Deuxième div avec quatre autres icônes -->
        <div class="navbar-icons">
            <?php
            if ($noteType == "archived"){
                //delete
            echo '<a href="index/deleteNote/'. $note->getId() .'">';
            echo ' <i class="fa-solid fs-1 fa-calendar-xmark"></i>';
            echo '</a>';
            //unarchived
                echo '<a href="index/unarchive/' . $note->getId() . '"><i class="fa-solid fs-1 fa-box-open"></i></a>';
            }elseif ($noteType == "shared"){
                // edite share
                echo '<a href="#">';
                echo ' <i class="fa-regular fs-1 fa-pen-to-square"></i>';
                echo '</a>';
            }else{
                //share
                echo '<a href="index/view-share">';
                echo '  <i class="fa-solid fs-1 fa-share-nodes"></i>';
                echo '</a>';
                //pinned
                echo $note->isPinned() ? '<a href="index/unpin/' . $note->getId() . '"><i class="fa-solid  fs-1 fa-toggle-on"></i></a>' : '<a href="index/pin/' . $note->getId() . '"><i class="fa-solid  fs-1 fa-thumbtack"></i></a>';

                //archived
                echo $note->isArchived() ? '<a href="index/unarchive/' . $note->getId() . '"><i class="fa-solid  fs-1 fa-box-open"></i></a>' : '<a href="index/archive/' . $note->getId() . '"><i class="fa-solid fs-1 fa-box-archive"></i></a>';

                //edited
                echo '<a href="#">';
                echo ' <i class="fa-regular fs-1 fa-pen-to-square"></i>';
                echo '</a>';
            }
            ?>


        </div>
    </div>
</nav>