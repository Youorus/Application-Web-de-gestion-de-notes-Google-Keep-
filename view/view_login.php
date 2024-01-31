<!-- importation de l'entete de page  -->
<?php
require_once "head.php";
?>
<div class="box-login">
<div class="signup-box">
  <h2>Log In</h2>
  <hr>
  <form action="main/login" method="post">    
    <div class="form-group input">
    <i class="fa-regular fa-user icon"></i>
      <input type="email" id="mail" name="mail" placeholder="Enter your email" value="<?= $mail ?>">
    </div>

    <div class="form-group input">
    <i class="fa-solid fa-lock icon"></i>
      <input type="password" id="password"  name="password" placeholder="Enter your password" value="<?= $password ?>">
    </div>

    <button type="submit" class="signup-btn">Login</button>
    <br>
    <br>
    <a href="main/signup">New here? Click here to subcribe !</a>
  </form>
  <br>

  <?php if (count($errors) != 0): ?>
                <div class="errors">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
</div>
</div>

<!-- Font Awesome pour les icônes -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>
</html>