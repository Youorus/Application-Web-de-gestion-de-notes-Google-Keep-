<?php
if (!empty($userSharesNotes)) {
    foreach ($userSharesNotes as $user) {
        echo ' <li class="nav-item">';
        echo '<a class="nav-link moi" aria-current="page" href="index/share_notes/'.$user->getId().'">' ."Shared by ". $user->getFullName() . '</a>';
        echo '</li>';
    }
} else {
    echo ' <li class="nav-item">';
    echo '<a class="nav-link moi">' ."No shared notes found". '</a>';
    echo '</li>';
}
?>