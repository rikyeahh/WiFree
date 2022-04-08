// display what is in the cart in myCart.php page
var total = 0;
var productSummary = document.getElementById("productSummary"); // the recap box
var cart = JSON.parse(localStorage.getItem("cart"));
// for each product in the cart, display a line with its info
Object.entries(cart).forEach((product, i) => { // forEach iteration to ensure correct async execution
    var productId = product[0]; // keys of cart
    var productQty = product[1]; // values of cart
    // AJAX request to get the info
    console.log("invio info per " + productId + " " + productQty);
    var xhr = getXMLHttpRequestObject();
    xhr.onreadystatechange = function() {
        if ((xhr.readyState == 4) & (xhr.status == 200)) {
            var response = xhr.responseText;
            console.log(response);
            if (response.includes("ERROR")) {
                productSummary.innerHTML += "Error";
            }
            else {
                // product info in JSON format
                console.log(response);
                response = JSON.parse(response);
                // output the info and update the total, Math.round to prevent rounding problems
                productSummary.innerHTML += (response.name + " x" + productQty + " = " + Math.round(response.price * productQty * 100) / 100 + "€<br>");
                total += Math.round(response.price * productQty * 100) / 100;
                if (response.availability < productQty) { // if qty in cart is more than the availability in the db, display error
                    productSummary.innerHTML += "<p class='error'>Solo " + response.availability + " disponibili per il prodotto "+response.name+"</p><br>";
                }
            }
            if (Object.is(Object.entries(cart).length - 1, i)) { // on last iteration, update the total field
                document.getElementById("totalPrice").innerHTML = ("Totale: " + Math.round(total * 100) / 100 + "€");
            }
        }
    };
    xhr.open('GET', "./getProductInfo.php?id=" + encodeURIComponent(productId));
    xhr.send(null);
});

// functionality of "Svuota carrello" button
document.getElementById("clearCart").addEventListener('click', function(event) {
    localStorage.setItem("cart", "{}"); // reset the cart
    window.location.reload(false); // reload the page
});

// functionality of "Compra" button
document.getElementById("buy").addEventListener('click', function(event) {
    // AJAX request to communicate what am i buying (and possibly update the db)
    var xhr = getXMLHttpRequestObject();
    xhr.onreadystatechange = function() {
        if ((xhr.readyState == 4) & (xhr.status == 200)) {
            var response = xhr.responseText;
            if (response == "") { // no error
                localStorage.setItem("cart", "{}"); // reset the cart
                window.alert("Grazie per aver comprato da noi"); // show a message
                window.location.reload(false); // reload the page
            }
            else { // some error: often trying to buy a qty > than that available
                if (response == "AVAILABILITY ERROR") {
                    window.alert("Errore: stai provando a comprare più prodotti di quanti sono disponibili");
                }
                else {
                    window.alert("Errore: riprova più tardi");
                }
            }
        }
    }
    var cart = localStorage.getItem("cart");
    var url = "./buy.php?cart=" + encodeURIComponent(cart);
    xhr.open('GET', url);
    xhr.send(null);
});
