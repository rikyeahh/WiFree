// add adminNavbar toggle functionality
var adminNavbarToggle = document.getElementById('adminNavbarToggle');
adminNavbarToggle.addEventListener('click', function() {
    var x = document.getElementById("adminNavbar");
    if (x.style.display === "none") { // if invisible, make it visible
        x.style.display = "block";
    } else { // else, make it invisible
        x.style.display = "none";
    }
});
// toggle the adminNavbar off (by deafult it is on, display = block)
adminNavbarToggle.click();
