/* ids of errors in errorBox are:

passTooShort, passIsUnsafe passDiffers,
emailAlreadyInD
*/

/* utility functions for errors */

// removes error node with specified id
function cleanErrorById(id) {
    if (existsErrorWithId(id))
        document.getElementById(id).remove();
}

function createError(id, string) {
    if (!existsErrorWithId(id))
        document.getElementById("errorBox").innerHTML += ("<p class='error' id='" + id + "'>" + string + "</p>");
}

function existsErrorWithId(id) {
    return document.getElementById(id) != null;
}

/* utility functions for input validation */

// check if password is long enough (8 chars, could be more)
function passTooShort(password) {
    return (password.length < 8);
}

// checks if password is an obvious one
function passIsUnsafe(password) {
    var obvPass = ["password", "1234", "1234567890", "ciaociao", "qwertyui", "qwertyuiop"]; // and many others
    return obvPass.includes(password);
}

/* actual checks on input */

// check performed on form submit: if input is invalid form submission is cancelled
var form = document.getElementById('registrationForm');
form.addEventListener('submit', function(event){
    var password = document.getElementById('pass').value;
    var confirm = document.getElementById('confirm').value;
    var submit = document.getElementById('submit');
    // check for password length
    if (passTooShort(password)) {
        createError("passTooShort", "La password è troppo corta");
        event.preventDefault();
    }
    else {
        cleanErrorById("passTooShort");
    }
    // check for password safeness
    if (passIsUnsafe(password)) {
        createError("passIsUnsafe", "La password è banale...");
        event.preventDefault();
    }
    else {
        cleanErrorById("passIsUnsafe");
    }
    // check for password == confirm
    if (password != confirm) {
        createError("passDiffers", "La password è diversa dalla conferma");
        event.preventDefault();
    }
    else {
        cleanErrorById("passDiffers");
    }
    // check for whitespace
    if ((password != password.trim())){
        createError("hasWhitespace", "Attento a spazi bianchi iniziali o finali");
        event.preventDefault();
    }
    else {
        cleanErrorById("hasWhitespace");
    }
});

/**********************************************************************/
/* checks performed on input fields change, do not prevent form submit */
/* except with this first one */

// check if email inserted is already used and shows error
var email = document.getElementById('email');
email.addEventListener('change', function(){
    var email = document.getElementById('email').value;
    // AJAX requesto to know if specified email is aldready in database
    var xhr = getXMLHttpRequestObject();
    xhr.onreadystatechange = function() {
        if ((xhr.readyState == 4) & (xhr.status == 200)) {
            var response = xhr.responseText;
            console.log(response);
            if (response != "OK") { // email already in database
                createError("emailAlreadyInDb", "Email già usata, prova con una diversa");
                document.getElementById('submit').disabled = true;
            }
            else {
                cleanErrorById("emailAlreadyInDb");
                document.getElementById('submit').disabled = false;
            }
        }
    }
    xhr.open('GET', "./checkEmail.php?email=" + encodeURIComponent(email), true);
    xhr.send(null);
});

// check if password is long enough, performed on password field change
var pass = document.getElementById('pass');
pass.addEventListener('change', function(){
    var password = document.getElementById('pass').value;
    if (passTooShort(password)) {
        createError("passTooShort", "La password è troppo corta");
    }
    else {
        cleanErrorById("passTooShort");
    }
});

// check for password safeness, performed on password field change
pass.addEventListener('change', function(){
    var password = document.getElementById('pass').value;
    if (passIsUnsafe(password)) {
        createError("passIsUnsafe", "La password è banale...");
    }
    else {
        cleanErrorById("passIsUnsafe");
    }
});

// check if pass confirm == password, performed on confirm field change
var confirm = document.getElementById('confirm');
confirm.addEventListener('change', function(){
    var password = document.getElementById('pass').value;
    var confirmP = document.getElementById('confirm').value;
    if (password != confirmP) {
        createError("passDiffers", "La password è diversa dalla conferma");
    }
});


// check for whitespace, performed on password field change
pass.addEventListener('change', function(){
    var password = document.getElementById('pass').value;
    if ((password != password.trim())){
        createError("hasWhitespace", "Attento a spazi bianchi iniziali o finali");
        event.preventDefault();
    }
    else {
        cleanErrorById("hasWhitespace");
    }
});
