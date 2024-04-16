let title_note, titleError, item, itemError;

function checkTitle() {
    titleError.text("");
    if (title_note.val().length < 3)
        titleError.text("The title must have more than " + minLenght + " characters");
    if (title_note.val().length > 25)
        titleError.text("The title must have less than " + maxLenght + " characters");
}

