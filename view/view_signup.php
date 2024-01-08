<!-- Importation de l'entête de page -->
<?php require_once "utils/head.php"; ?>

</head>
<body>
<div class="signup-box">
    <h2>Signup</h2>
    <hr>
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
            <label for="fullname">Full Name </label>
            <input type="text" id="fullname" name="fullname" placeholder="Full Name" value="<?= $fullname ?>" required>
        </div>

        <div class="form-group input">
            <i class="icon fas fa-envelope"></i>
            <label for="email">Email </label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?= $mail ?>" required>
        </div>

        <div class="form-group input">
            <i class="icon fas fa-lock"></i>
            <label for="password">Password </label>
            <input type="password" id="password" name="password" placeholder="Password" value="<?= $password ?>" required>
        </div>

        <div class="form-group input">
            <i class="icon fas fa-lock"></i>
            <label for="confirm-password">Confirm Password </label>
            <input type="password" id="passwordconfirm" name="passwordconfirm" placeholder="Confirm Password" value="<?= $passwordconfirm ?>" required>
        </div>

        <button type="submit" class="signup-btn">Sign Up</button>
        <br>
        <br>

        <div class="login-link">
            Already have an account? <a href="main/login">Click here to login!</a>
        </div>
    </form>
    <br>

</div>

<!-- Font Awesome pour les icônes -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script> -->

</body>

</html>