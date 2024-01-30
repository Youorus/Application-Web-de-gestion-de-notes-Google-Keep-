<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Note</title>
    <link href="css/style.css" rel="stylesheet" />
    <!-- Add other required CSS or JS here -->
</head>
<body>
<div class="note-container">
    <p class="note-times">
        Created <?= htmlspecialchars($messageCreate); ?>.
        <?= $messageEdit ? 'Edited ' . htmlspecialchars($messageEdit) . '.' : ''; ?>
    </p>
    <h2 class="note-title"><?= htmlspecialchars($title); ?></h2>
    <div class="checklist-items">
        <?php foreach ($content as $item): ?>
            <div class="checklist-item">
                <input type="checkbox" <?= $item->getChecked() ? 'checked' : ''; ?> disabled>
                <label><?= $item->getContent(); ?></label>
            </div>
        <?php endforeach; ?>
    </div>

</div>
</body>
</html>
