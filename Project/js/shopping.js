// utility method for managing localStorage cart as a JSON string

// gets quantity of product of specified id from cart
function getQtyFromCart(id){
    var cart = JSON.parse(localStorage.getItem("cart"));
    return cart[id] || 0;
}

// adds 1 item of specified id to cart
function addToCart(id) {
    var cart = JSON.parse(localStorage.getItem("cart"));
    cart[id] = (getQtyFromCart(id) + 1);
    localStorage.setItem("cart", JSON.stringify(cart));
}

// initialize cart as JSON empty object if not defined
if (localStorage.getItem("cart") === null) {
    localStorage.setItem("cart", "{}");
}

// get all addToCart buttons
var addToCartButtons = document.getElementsByClassName("addToCart");
// for each one, display current quantity in cart and add a function that retrieves product name
for (var i = 0; i < addToCartButtons.length; i++) {
    // take the inCart HTML text and show it updated with localStorage.getItem(productId)
    currentId = addToCartButtons[i].parentElement.children[0].innerHTML;
    addToCartButtons[i].parentElement.children[1].children[0].innerHTML = getQtyFromCart(currentId);
    // function to update values (add to cart) on click
    addToCartButtons[i].addEventListener('click', function(event) {
        // id of the product you clicked on
        var productId = event.composedPath()[1].children[0].innerHTML;
        // "Nel carrello" label/counter
        var qtyInCart = event.composedPath()[1].children[1].children[0];
        // increment the counter in localstorage
        addToCart(productId);
        // update the label
        qtyInCart.innerHTML = getQtyFromCart(productId);
    });
}
