<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<?php if (!empty($success)): ?>
    <p><?= $success ?></p>
<?php else: ?>
    <h1>Modifier le Profile</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="settings/edit_profile">
        <div>
            <label for="full_name">Nom Complet :</label>
            <input type="text" id="full_name" name="full_name" value="<?= $user->full_name ?>" required>
        </div>
        <div>
            <button type="submit">Mettre à jour le profil</button>
        </div>
    </form>

<?php endif; ?>
</body>
</html>
