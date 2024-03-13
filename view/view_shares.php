<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>

    <div class="navbar navbar-dark bg-dark fixed">
        <div class="container">
            <!-- Bouton de retour -->
            <div class="navbar-icon">
                <a href="index">
                    <span class="material-symbols-outlined"> arrow_back_ios </span>
                </a>
            </div>
        </div>
    </div>


        <div class="open-text">
            <h3> Shares:</h3>
            <?php
            if (!$note->isShared())
                echo '<h5><i>This notes is not shared yet.</i></h5>';
            ?>
            <div class="mb-3">
                <form id="addTextNote" method="POST" action="AddTextNote/add_text_note">
                    <div class="input-group ">
                        <select class="form-select dark-bg" id="inputGroupSelect01">
                            <option selected>-User-</option>
                            <?php if (!$note->isShared()): ?>
                                <?php foreach ($otherUsers as $user): ?>
                                    <option value=""> <?php echo $user; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <select class="form-select dark-bg" id="inputGroupSelect01">
                            <option selected>-Permission-</option>
                            <option value="editor">Editor</option>
                            <option value="reader">Reader</option>
                        </select>
                        <button class="btn btn-primary" type="submit">+</button>
                    </div>
        </div>



</body>
</html>
