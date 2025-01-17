<nav class="navbar navbar-dark bg-dark fixed">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo $title; ?></a>
        <!-- menu deroulant -->
        <div class="offcanvas offcanvas-start navbar-dark bg-dark text-bg-dark" tabindex="-5" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title text-warning" id="offcanvasDarkNavbarLabel">NoteApp</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- corps de la liste deroulante  -->
            <div class="offcanvas-body ">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link moi" aria-current="page" href="index/index">My notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link moi" aria-current="page" href="index/archive_notes">My archives</a>
                    </li>
                   <?php include  "utils/usersSharesNotes.php" ?>
                    <li class="nav-item">
                        <a class="nav-link moi" aria-current="page" href="Settings">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
