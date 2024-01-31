<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<div class="note-container">
    <?php include "utils/open_note_navbar.php"?>
    <h2 class="note-title"><?= $title ?></h2>
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
