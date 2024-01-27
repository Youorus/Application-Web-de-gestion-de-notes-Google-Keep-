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

</head>

  <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <?php
                require_once 'NoteShare.php';

                if(isset($_GET['id'])){
                    $noteId = $_GET['id'];
                    $noteType = getType($noteId);

                    if ($noteType == 'checklist') {
                        header('Location: view_checklist_note.php?id=' . $noteId); //mettre le vrai nom de la vue de open check list note de anass
                    } else {
                        header('Location: index/open_text_note.php?id=' . $noteId);
                    }
                }
                ?>
                <a href="index/.php">
                    <i class="material-icons">
                        <span class="material-symbols-outlined">
                            arrow_back_ios 
                        </span>
                    </i>
                </a>    