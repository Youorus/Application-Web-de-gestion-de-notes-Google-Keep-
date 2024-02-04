<!-- importation de l'entete de page  -->
<?php
require_once "head.php";
?>
<div class="box-login">
    <div class="signup-box">
        <h2>Edit Profile</h2>
        <hr>

        <form action="settings/edit_profile" method="post">
            <div class="form-group input">
                <i class="fa-regular fa-user icon"></i>
                <input type="text" id="mail"  value="<?= $user_name ?>"  name="full_name"  ">
            </div>

            <div class="form-group input">
                <i class="fa-regular fa-envelope icon"></i>
                <input type="email" id="password" value="<?= $user_mail ?>" name="email"  ">
            </div>

            <div class="btn-editProfile">
                <span ><a href="settings/cancel" class="btn-danger edit-cancel" >Cancel</a></span>
            <button type="submit" class="btn-success edit-save">Save</button>
            </div>
        </form>

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