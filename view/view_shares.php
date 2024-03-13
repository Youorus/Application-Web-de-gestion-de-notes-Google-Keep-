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
            <div class="mb-3">
                <form id="addTextNote" method="POST" action="AddTextNote/add_text_note">
                    <div class="input-group ">
                        <select class="form-select dark-bg" id="inputGroupSelect01">
                            <option selected>-User-</option>

                        </select>
                        <select class="form-select dark-bg" id="inputGroupSelect01">
                            <option selected>-Permission-</option>
                            <option value="1">One</option>

                        </select>
                        <button class="btn btn-primary" type="submit">Button</button>
                    </div>
        </div>



</body>
</html>
