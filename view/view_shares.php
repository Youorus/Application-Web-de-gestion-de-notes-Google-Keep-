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
                <form id="addTextNote" method="POST" action="Share/add">
                    <div class="input-group ">
                        <select class="form-select dark-bg" id="inputGroupSelect01" name="userId">
                            <option selected>-User-</option>
                            <?php if (!$note->isShared()): ?>
                                <?php foreach ($otherUsers as $user): ?>
                                    <option value="<?= $user->getId() ?>"> <?= $user->getFullName() ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <select class="form-select dark-bg" id="inputGroupSelect02" name="permission">
                            <option selected>-Permission-</option>
                            <option  value="1">Editor</option>
                            <option  value="0">Reader</option>
                        </select>
                        <button class="btn btn-primary" type="submit">+</button>
                    </div>
                    <input name="idNote" value="<?= $idNote ?>" type="hidden">
                </form>
        </div>



</body>
</html>
