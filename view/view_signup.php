<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<div class="signup-box">
    <h2>Signup</h2>
    <hr>

    <!-- Bloc pour afficher les messages d'erreur -->
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p class="error"><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="main/signup" method="post">
        <div class="form-group input">
            <i class="icon fas fa-user"></i>
            <input type="text" id="full_name" name="full_name" placeholder="Full Name" value="<?= $full_name ?>" required>
        </div>

        <div class="form-group input">
            <i class="icon fas fa-envelope"></i>
            <input type="email" id="email" name="email" placeholder="Email" value="<?= $email ?>" required>
        </div>

        <div class="form-group input">
            <i class="icon fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>

        <div class="form-group input">
            <i class="icon fas fa-lock"></i>
            <input type="password" id="passwordconfirm" name="passwordconfirm" placeholder="Confirm Password" required>
        </div>

        <button type="submit" class="signup-btn">Sign Up</button>
        <div class="login-link">
            Already have an account? <a href="main/login">Click here to login!</a>
        </div>
    </form>

</div>
<!-- Font Awesome pour les icônes -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script> -->
</body>
</html>
