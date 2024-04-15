<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<div class="note-container">
    <?php include "utils/open_note_navbar.php"?>

    </div>
    <div class="open-text">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($title) ?>">
        <div class="checklist-items">
            <label class="form-label">Items</label>
            <?php foreach ($content as $item): ?>
                    <form action="Checklistnote/check_uncheck" method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input  mt-0" type="checkbox" name="checked" value="1" <?= $item->getChecked() ? 'checked' : ''; ?> onchange="this.form.submit();" aria-label="Checkbox for following text input">
                            </div>
                            <?php
                            if ($item->getChecked() == 1)
                                echo '<input type="text" class="form-control check-text" value="' . htmlspecialchars($item->getContent()) . '" aria-label="Text input with checkbox" readonly>';
                            else
                                echo '<input type="text" class="form-control" value="' . htmlspecialchars($item->getContent()) . '" aria-label="Text input with checkbox" readonly>';
                            ?>
                            <input type="hidden" name="item_id" value="<?= $item->getId(); ?>">
                            <input type="hidden" name="idnote" value="<?= $idnote ?>">
                        </div>
                    </form>
            <?php endforeach; ?>
        </div>
    </div>
<script src="path_to_your/bootstrap_bundle.js"></script>
</body>
</html>
