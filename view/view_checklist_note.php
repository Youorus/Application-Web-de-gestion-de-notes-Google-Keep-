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

                <form class="flex-grow-1 me-2" ">
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0 checkbox-item" type="checkbox" name="checked" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" data-item-id="<?= $item->getId(); ?>">
                            </div>
                            <?php
                            if ($item->getChecked() == 1)
                                echo '<input id="check-item'. $item->getId() . '" type="text" class="form-control check-text" value="' . htmlspecialchars($item->getContent()) . '" aria-label="Text input with checkbox" readonly>';
                            else
                                echo '<input id="check-item'. $item->getId() . '" type="text" class="form-control" value="' . htmlspecialchars($item->getContent()) . '" aria-label="Text input with checkbox" readonly>';
                            ?>
                            <input type="hidden" name="item_id" value="<?= $item->getId(); ?>">
                            <input type="hidden" name="idnote" value="<?= $idnote ?>">
                        </div>
                    </form>
            <!--
                <form class="flex-grow-1 me-2" ">
                <div class="input-group">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 checkbox-item" type="checkbox" name="checked" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" data-item-id="<?= $item->getId(); ?>">
                    </div>
                    <input type="text" class="form-control item-content" value="<?= htmlspecialchars($item->getContent()); ?>" disabled>
                    <input type="hidden" class="item-id" value="<?= $item->getId(); ?>">
                </div>
                </form>
                -->
            <?php endforeach; ?>
        </div>
    </div>
<script src="path_to_your/bootstrap_bundle.js"></script>

<script>
    $(document).ready(function() {
        $('.checkbox-item').change(function() {
            var checkbox = $(this);
            var itemId = checkbox.data('item-id');
            var isChecked = checkbox.is(':checked') ? 1 : 0;

            $.ajax({
                url: 'Checklistnote/check_uncheck/' + itemId + '/' + isChecked ,
                type: 'GET',
                data: {
                    item_id: itemId,
                    checked: isChecked
                },
                success: function (res){

                    if(isChecked === 0) {
                        $('#check-item' + itemId).removeClass('check-text');

                    } else {
                        $('#check-item' + itemId).addClass('check-text');

                    }

                    console.log(res);


                },
                error: function() {
                    // Rétablit l'état précédent de la checkbox en cas d'erreur
                    checkbox.prop('checked', !isChecked);
                }
            });
        });
    });
</script>
</body>
</html>
