<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Checklist Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>


<body class="bg-dark">
<div class="container position-relative mt-5">
    <div class="position-absolute top-0 end-0">
        <button form="addChecklistForm" type="submit" class="btn btn-primary">Save</button>
    </div>
    <form id="addChecklistForm" action="index/add_checklist_note" method="post" class="bg-light p-4 rounded">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            <!-- Error display for title, if any -->
            <div class="text-danger">
                <!-- PHP code to display error if title is not valid -->
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Items</label>
            <!-- PHP loop to display 5 input fields for items -->
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="text" class="form-control mb-2" name="items[]" placeholder="Item <?= $i ?>">
            <?php endfor; ?>
            <!-- Error display for items, if any -->
            <div class="text-danger">
                <!-- PHP code to display error if items are not unique or any other error -->
            </div>
        </div>
    </form>
</div>
</body>
</html>
