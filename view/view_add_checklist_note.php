<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Checklist Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Ajoutez ici votre style CSS personnalisé si nécessaire */
    </style>
</head>
<body>
<div class="container mt-4">
    <form action="index/add_checklist_note" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
            <!-- Affichage de l'erreur pour le titre -->
            <div class="text-danger">
                Title length must be between 3 and 25
            </div>
        </div>
        <div class="mb-3">
            <label for="items" class="form-label">Items</label>
            <ul class="list-unstyled">
                <!-- Répéter cet élément pour chaque item de la checklist -->
                <li class="mb-2">
                    <input type="text" class="form-control" name="items[]" placeholder="Item name">
                    <div class="text-danger">
                        Items must be unique
                    </div>
                </li>
            </ul>
        </div>
        <!-- Bouton pour ajouter des items supplémentaires si nécessaire -->
        <div class="mb-3 text-end">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
