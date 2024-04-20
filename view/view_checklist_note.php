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
    <br>
    <div class="checklist-items">
        <?php foreach ($content as $item): ?>
            <form class="flex-grow-1 me-2" id="form-item<?= $item->getId() ?>">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 checkbox-item" type="checkbox" <?= $item->getChecked() ? 'checked' : ''; ?> aria-label="Checkbox for following text input" data-item-id="<?= $item->getId(); ?>">
                    </div>
                    <input type="text" id="check-item<?= $item->getId() ?>" class="form-control <?= $item->getChecked() ? 'check-text' : ''; ?>" value="<?= htmlspecialchars($item->getContent()) ?>" readonly>
                    <input type="hidden" name="item_id" value="<?= $item->getId(); ?>">
                    <input type="hidden" name="idnote" value="<?= $idnote ?>">
                </div>
            </form>
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
                url: 'Checklistnote/check_uncheck/' + itemId + '/' + isChecked,
                type: 'GET',
                success: function(res) {
                    if (isChecked) {
                        $('#check-item' + itemId).addClass('check-text');
                        moveItemToEnd('form-item' + itemId);
                    } else {
                        $('#check-item' + itemId).removeClass('check-text');
                        moveItemToStart('form-item' + itemId);
                    }
                },
                error: function() {
                    checkbox.prop('checked', !isChecked);
                }
            });
        });

        function moveItemToEnd(formId) {
            var form = $('#' + formId);
            form.appendTo('.checklist-items');
        }

        function moveItemToStart(formId) {
            var form = $('#' + formId);
            form.prependTo('.checklist-items');
        }
    });
</script>


</body>
</html>
