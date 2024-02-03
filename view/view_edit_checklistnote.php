<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<div class="note-container">
    <?php include "utils/open_note_navbar.php"?>


</div>
<div class="open-text">
    <label class="form-label">Title</label>
    <input type="text" class="form-control"  value="<?= htmlspecialchars($title) ?>">
    <div class="checklist-items">
        <label class="form-label">Items</label>

        <?php foreach ($content as $item): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="index/check_uncheck" method="post" class="flex-grow-1 me-2">
                    <div class="input-group">

                        <input type="text" class="form-control" value="<?= htmlspecialchars($item->getContent()); ?>" aria-label="Text input with checkbox" >
                        <input type="hidden" name="item_id" value="<?= $item->getId(); ?>">
                    </div>
                </form>
                <button class="btn delete-btn" type="button" aria-label="Delete">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
        <?php endforeach; ?>
        <div class="my-3">
            <label class="form-label">New Items</label>
            <div class="d-flex justify-content-between align-items-center">
                <form action="index/add_item" method="post" class="flex-grow-1 me-2">
                    <div class="input-group">
                        <input type="text" name="new_content" class="form-control" placeholder="New Item" aria-label="New item input" required>
                        <button class="btn add-btn" type="submit" aria-label="Add">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
