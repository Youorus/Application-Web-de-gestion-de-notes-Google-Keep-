<?php
for ($i = 0; $i < count($notesArchives); $i++) {
    echo '<div class="col-md-4">';
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title bord">' . $notesArchives[$i]->getTitle() . '</h5>';

    if ($notesArchives[$i]->getType() == NoteType::TextNote) {
        if ($notesArchives[$i]->getContent() === null) {
            echo '<p class="card-text">' . 'Note vide' . '</p>';
        }else {
            $length_string = strlen($notesArchives[$i]->getContent());
            if ($length_string > 80) {
                $tmp_string = "";
                for ($j = 0; $j < $length_string; $j++) {
                    $tmp_string .= $notesArchives[$i]->getContent()[$j];
                    if ($j == 80) {
                        break;
                    }
                }
                echo '<p class="card-text">' . $tmp_string . "..." . '</p>';
            } else {
                echo '<p class="card-text">' . $notesArchives[$i]->getContent() . '</p>';
            }
        }
    }else{
        $items = $notesArchives[$i]->getItems();
        foreach ($items as $item) {
            echo '<div class="form-check">';
            echo '  <input class="form-check-input" type="checkbox" value="1" id="exampleCheckbox" name="exampleCheckbox" ' . ($item ->getChecked() == 1 ? 'checked' : '') . '>';
            echo '  <label class="form-check-label" for="exampleCheckbox">';
            echo $item->getContent();
            echo '  </label>';
            echo '</div>';
        }
    }

    echo '</div>';
    echo '<div class="d-flex iconBox justify-content-between">';
    echo '<span><i class="fa-solid fa-angles-left "></i></span>';
    echo '<span><i class="fa-solid fa-angles-right"></i></span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

}

?>