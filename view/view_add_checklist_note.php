<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Checklist Note</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            /* Assume that your 'style.css' has a background style for the body. */
            /* If not, you can add a custom background here. */
        }
        .save-btn-container {
            position: fixed;
            right: 1rem;
            top: 1rem;
        }
        .container {
            margin-top: 3rem;
        }
    </style>
</head>
<body>
<!-- Save button at the top right corner -->
<div class="save-btn-container">
    <form action="index/add_checklist_note" method="post">
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<!-- Main container -->
<div class="container bg-light p-4">
    <form action="index/add_checklist_note" method="post">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
        </div>

        <!-- Items -->
        <div class="mb-3">
            <label class="form-label">Items</label>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="mb-2">
                    <input type="text" class="form-control" name="items[]" placeholder="Item <?= $i ?>" required>
                </div>
            <?php endfor; ?>
        </div>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
