/**
 * Displays a win or fail message depending on the validity of the choice that is selected
 * Makes question and choices disapear on selection
 * @param validity 
 */
function winOrFail(validity) {
    document.querySelector("#questionsAndAnswers").style.display = "none";
    document.querySelector("#passButton").innerHTML = "SUIVANT!";
    if (validity == 1) {
        document.querySelector("#winOrFailMessage").innerHTML = "Gagné!";
    } else if (validity == 0) {
        document.querySelector("#winOrFailMessage").innerHTML = "Perdu!";
    }
}

// Gets all choices (checkboxes and labels)
const choices = document.querySelectorAll(".choice");

/**
 * Creates an event listener for all checkboxes in class "choice" on the page
 * Calls winOrFail with the validity of the choice as parameter
 */
for (let i = 0; i < choices.length; i += 2) {
    choices[i].addEventListener("change", function() { winOrFail(choices[i].value) });
}