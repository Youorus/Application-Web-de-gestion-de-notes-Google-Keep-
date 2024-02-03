<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">

  <style>
        .material-icons{
            color: white;
        }
        .form-select {
            background-color:  var(--couleur-bordure);
            color: white; 
            border-radius: 0.25rem; 
            padding: 0.5rem 1rem; 
        }
        .btn-success {
            background-color: blue; 
            color: white; 
            padding: 0.5rem 1rem;
            margin-left: 0.5rem; 
        }
        .form-select option {
            background-color:  var(--couleur-bordure); 
            color: white;
        }
        .form-select:hover {
            background-color:  var(--couleur-bordure) !important; 
        }
        .form-select:hover {
            background-color:  var(--couleur-bordure) !important; 
        }
        .input-group {
            width: 100%;
        }
   </style> 

</head>
<body>

  <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark show" style="width:100vw;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                
                <a href="index/.php">
                    <i class="material-icons">
                        <span class="material-symbols-outlined">
                            arrow_back_ios 
                        </span>
                    </i>
                </a> 
            </div>

            <div class="container mt-3">
                <h2>Shares :</h2>
                <div id="shares-list" class="list-group">
                    <!-- Les éléments partagés seront ici -->
                </div>

                <!-- Formulaire pour ajouter un nouveau partage -->

                <form id="add-share-form" class="mt-3">
                    <div class="input-group">
                        <select id="user-select" class="form-select" required>
                            <option selected>-User-</option>
                            <?php
                            
                            foreach ($usersIds as $userId) {
                                // Utilisez la fonction get_fullname_User() pour récupérer le nom de l'utilisateur
                                $userFullName = User::get_fullname_User($userId);
                                echo "<option value='" . htmlspecialchars($userId) . "'>" . htmlspecialchars($userFullName) . "</option>";
                            }
                            ?>
                        </select>
                        <select id="permission-select" class="form-select" required>
                            <option selected>-Permission-</option>
                            <option value="reader">Lecteur</option>
                            <option value="editor">Éditeur</option>
                        </select>
                        <button type="button" id="add-share-btn" class="btn btn-success">+</button>
                    </div>
                </form>

                     



               
            </div>    
           


  </div>
</body>
</html>