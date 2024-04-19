
    let title_note, titleError, content_note, contentError, backBtn, myModal;

    //je recupere les valeur de mes input en js et je reste focus a mes entré de text


    function checkTitle(){
    titleError.text("");
    if (title_note.val().length < minLenght )
    titleError.text("The title must have more than " + minLenght + " characters");
    if (title_note.val().length > maxLenght)
    titleError.text("The title must have less than " + maxLenght + " characters");
}

    function checkContent() {
    contentError.text("");
    if (content_note.val() !== "") {
    if (content_note.val().length < minLenght) {
    contentError.text("The title must have more than " + minLenght + " characters");
}
}
}

    async function checkTitleExist() {
    const data = await $.post("AddTextNote/validate/", {test: title_note.val()});
    if (data === "true") {
    titleError.text("This title already exists");
}
}

    function modalShow() {
        if (title_note.val() !== title || content_note.val() !== content) {
            $("#myModalSave").modal("show");
        } else {
            window.location.href = "index";
        }
    }


    $(function (){
    title_note = $("#title_note");
    titleError = $("#titleError");
    content_note = $("#content_note");
    contentError = $("#contentError");
        backBtn = $("#back");

        backBtn.bind("click", modalShow);
    title_note.bind("input", checkTitle);
    content_note.bind("input", checkContent);


    $("input:text:first").focus();
})
