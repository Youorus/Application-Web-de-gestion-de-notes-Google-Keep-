<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<div class="note-container">
    <?php include "utils/open_note_navbar.php"?>
    <div class="open-text">
        <label  class="form-label">Title</label>
        <input type="text" class="form-control" readonly value="<?= $title ?>">
        <div class="checklist-items">
            <label  class="form-label">items</label>
            <?php foreach ($content as $item): ?>
                <div class="checklist-item">
                    <input type="checkbox" <?= $item->getChecked() ? 'checked' : ''; ?>
                    <label><?= $item->getContent(); ?></label>
                </div>
            <?php endforeach; ?>
        </div>

    </div>


</div>
</body>
</html>
