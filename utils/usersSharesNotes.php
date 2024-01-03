<?php
if (!empty($userSharesNotes)) {
    foreach ($userSharesNotes as $user) {
        echo ' <li class="nav-item">';
        echo '<a class="nav-link moi" aria-current="page" href="index/archive_notes">' ."Shared by ". $user . '</a>';
        echo '</li>';
    }
} else {
    echo ' <li class="nav-item">';
    echo '<a class="nav-link moi">' ."No shared notes found". '</a>';
    echo '</li>';
}
?>