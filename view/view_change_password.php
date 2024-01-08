<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Changer le mot de passe</title>
    <base href="<?= $web_root ?>">
</head>
<body>
<?php if (!empty($successMessage)): ?>
    <p><?= $successMessage ?></p>
<?php else: ?>
    <h1>Changer le mot de passe</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="settings/change_password">
        <div>
            <label for="currentpassword">Mot de passe actuel :</label>
            <input type="password" id="currentpassword" name="currentpassword"  required>
        </div>
        <div>
            <label for="newpassword">Nouveau mot de passe :</label>
            <input type="password" id="newpassword" name="newpassword" required>
        </div>
        <div>
            <label for="confirmpassword">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirmpassword" name="confirmpassword" required>
        </div>
        <div>
            <button type="submit">Changer le mot de passe</button>
        </div>
    </form>
<?php endif; ?>
</body>
</html>
