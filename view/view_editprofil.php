<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Profile <?= $user->full_name ?></title>
    <base href="<?= $web_root ?>">
</head>
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
    <form method="post" action="user/edit_profile">
        <div>
            <label for="full_name">Nom Complet :</label>
            <input type="text" id="full_name" name="full_name"  value="<?= $user->full_name ?>"  required>
        </div>
        <div>
            <label for="mail">Adresse Email :</label>
            <input type="email" id="mail" name="mail" value="<?= $user->mail ?>" required>
        </div>
        <div>
            <button type="submit">Mettre à jour le profil</button>
        </div>
    </form>
<?php endif; ?>
</body>
</html>