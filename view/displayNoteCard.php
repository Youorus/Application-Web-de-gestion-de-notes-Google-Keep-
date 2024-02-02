<?php

function displayNoteCard($note) {
$href = ($note->getType() == NoteType::TextNote) ?
'index/open_text_note/' . $note->getId() :
'index/open_checkList_note/' . $note->getId();

echo '<a href="' . $href . '" class="card-link">';
    echo '<div class="card-body">';
        echo '<h5 class="card-title bord">' . $note->getTitle() . '</h5>';

        if ($note->getType() == NoteType::TextNote) {
        if ($note->getContent() === null) {
        echo '<p class="card-text">' . 'Note vide' . '</p>';
        } else {
        $length_string = strlen($note->getContent());
        if ($length_string > 80) {
        $tmp_string = "";
        for ($j = 0; $j < $length_string; $j++) {
        $tmp_string .= $note->getContent()[$j];
        if ($j == 80) {
        break;
        }
        }
        echo '<p class="card-text">' . $tmp_string . "..." . '</p>';
        } else {
        echo '<p class="card-text">' . $note->getContent() . '</p>';
        }
        }
        } else {
        $items = $note->getItems();
        $cpt = 0;
            foreach ($items as $item) {
                if ($cpt < 3){
                    $cpt++;
                    echo '<div class="form-check">';
                    echo '  <input class="form-check-input" type="checkbox" value="1" id="exampleCheckbox" name="exampleCheckbox" ' . ($item->getChecked() == 1 ? 'checked' : '') . '>';
                    echo '  <label class="form-check-label" for="exampleCheckbox">';
                    echo $item->getContent();
                    echo '  </label>';
                    echo '</div>';
                }else{
                    echo '<p class="checkBoxFinish">' . "...". '</p>';
                    break;
                }

            }
        }

        echo '</div>';
    echo '</a>';
echo '<div class="d-flex iconBox justify-content-between">';
            echo '<span><i class="fa-solid fa-angles-left"></i></span>';
            echo '<span><i class="fa-solid fa-angles-right"></i></span>';

    echo '</div>';
}


?>