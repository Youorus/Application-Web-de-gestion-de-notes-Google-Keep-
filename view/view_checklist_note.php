<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Checklist Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-dark">

<?php include "utils/open_note_navbar.php"?>

<div class="container mt-4 bg-light p-4 rounded">
    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" id="title" class="form-control" value="<?= ($title); ?>" readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">Items:</label>
        <ul class="list-group">
            <?php foreach ($content as $item): ?>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="checkbox" value="" <?= $item->getChecked() ? 'checked' : ''; ?> disabled>
                    <?= ($item->getContent()); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="text-muted">
        <small><?= $messageCreate; ?></small>
        <?php if (!is_null($messageEdit)): ?>
            <small>Edited <?= $messageEdit; ?>.</small>
        <?php endif; ?>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary mt-3">Back</a>
</div>
</body>
</html>
