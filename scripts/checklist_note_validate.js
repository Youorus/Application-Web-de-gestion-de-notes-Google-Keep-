let title_note, titleError, itemsArray, itemError;

function checkTitle() {
    titleError.text("");

    if (title_note < minLenght) {
        titleError.text("The title must have more than " + minLenght + " characters");
    } else if (title_note > maxLenght) {
        titleError.text("The title must have less than " + maxLenght + " characters");
    }
}

function collectItems() {
    // Tableau pour stocker les valeurs des items
    let itemsArray = [];

    // Sélectionner tous les champs d'entrée qui contiennent le contenu des items
    const itemInputs = document.querySelectorAll('.item-content');

    // Itérer sur chaque champ d'entrée pour extraire et stocker sa valeur
    itemInputs.forEach(input => {
        let itemValue = input.value.trim();  // Nettoyer la valeur pour enlever les espaces superflus
        if (itemValue) {  // Vérifier si la valeur n'est pas vide
            itemsArray.push(itemValue);
        }
    });

    // Retourner le tableau contenant toutes les valeurs collectées
    return itemsArray;
}




function checkItem() {
    itemError.text("");
    let currentItemValue = item.val().trim();

    if (currentItemValue.length < config.itemMinLength) {
        itemError.text("Item must have at least " + config.itemMinLength + " characters.");
        return;
    }
    if (currentItemValue.length > config.itemMaxLength) {
        itemError.text("Item must have less than " + config.itemMaxLength + " characters.");
        return;
    }

    itemsArray = collectItems();
    if (itemsArray.includes(currentItemValue)) {
        itemError.text("Il ne peut pas y avoir 2 items ou plus du même nom.");
    } else {
        console.log("L'item peut être ajouté.");
    }
}


$(function () {
    title_note = $("#title");
    titleError = $("#titleError");
    content_note = $("#itemcontent");
    contentError = $("#itemError");

    title_note.bind("input", checkTitle);
    title_note.bind("blur", checkTitleExist);
    content_note.bind("input", checkContent);

    $("input:text:first").focus();
})
