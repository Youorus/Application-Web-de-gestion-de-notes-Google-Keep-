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

    <style>
        .open-text{
            margin: 4% 5% 0 5%;
        }
        .infoText{
            font-style: italic;
            font-weight: normal;
            font-size: initial;
            margin-bottom: 2%;
        }
        .form-label{
            font-size: larger;
        }
        .form-control {
            background-color: var(--couleur-bordure) !important;
            color: var(--couleur-texte);
            border-color: var(--couleur-bordure);
        }
    </style>
</head>
<body>

<?php include "open_note_navbar.php"?>

<div class=" open-text">
<div class="mb-3">
    <h5 class="infoText"> Created <?= $messageCreate ?>. Edited <?= $messageEdit ?>.  </h5>
        <label  class="form-label">Title</label>
    <input type="text" class="form-control" readonly value="<?= $title ?>">
</div>
<div class="mb-3">
    <label  class="form-label">Text</label>
    <textarea class="form-control" readonly rows="10" > <?= $content == null? "Note Vide": $content ?> </textarea>
</div>
</div>


</body>
</html>