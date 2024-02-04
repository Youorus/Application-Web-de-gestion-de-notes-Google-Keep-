<html lang="en">
<?php include "head.php"?>
<body>

<?php include "utils/open_note_navbar.php"?>


<body>
<div class="container position-relative mt-5">
    <form id="addChecklistForm" action="index/add_checklistnote" method="post" class="bg-dark p-4 rounded">
    <div class="position-absolute top-0 end-0">
        <button type="submit" class="btn"><i class="fa-solid fa-floppy-disk"></i>
    </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            <?php if (!empty($errors['title'])): ?>
                <div class="text-danger"><?= htmlspecialchars($errors['title']); ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Items</label>
            <?php for ($i = 0; $i <= 4; $i++): ?>
                <div class="mb-2">
                    <input type="text" class="form-control" id="items[]" name="items[]" placeholder="Item <?= $i ?>">
                    <?php if (!empty($errors["item$i"])): ?>
                        <div class="text-danger"><?= htmlspecialchars($errors["item$i"]); ?></div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
