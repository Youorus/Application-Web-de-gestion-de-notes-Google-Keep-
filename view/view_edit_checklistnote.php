<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<div class="note-container">
    <?php include "utils/open_note_navbar.php"?>


</div>
<form action="index/editchecklistnote" method="post">
    <button type="submit" class="btn btn-primary">Save</button>
<div class="open-text">
    <label class="form-label">Title</label>
    <input id="title" name="title" type="text" class="form-control"  value="<?= $title ?>">
    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
</form>
    <div class="checklist-items">
        <label class="form-label">Items</label>

        <?php foreach ($content as $item): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="index/check_uncheck" method="post" class="flex-grow-1 me-2">
                    <div class="input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="checked" value="1" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" disabled>
                        </div>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($item->getContent()); ?>" aria-label="Text input with checkbox" >
                        <input type="hidden" name="item_id" value="<?= $item->getId(); ?>">
                    </div>
                </form>
                <form action="index/delete_item" method="post">
                    <input type="hidden" id="id_item" name="id_item" value="<?= $item->getId(); ?>">
                    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
                    <button class="btn delete-btn" type="submit" aria-label="Delete">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </form>

            </div>
        <?php endforeach; ?>
        <div class="my-3">
            <label class="form-label">New Items</label>
            <div class="d-flex justify-content-between align-items-center">
                <form action="index/add_item" method="post" class="flex-grow-1 me-2">
                    <input type="hidden" id="idnote" name="idnote" value="<?= $note->getId(); ?>">
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="New Item" aria-label="New item input" >
                        <button class="btn add-btn" type="submit" aria-label="Add">
                            <i class="bi bi-plus-lg"></i>
                            <input type="hidden" id="id_item" name="id_item" value="<?= $item->getId(); ?>">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
