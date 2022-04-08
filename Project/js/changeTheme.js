// changes css variables to match chosen theme
function changeThemeColor(primary, secondary, others) {
    var root = document.documentElement;
    root.style.setProperty("--primary-color", primary);
    root.style.setProperty("--secondary-color", secondary);
    root.style.setProperty("--others-color", others);
}

// simplifies meaning of this particular localStorage usage
function saveTheme(theme) {
    localStorage.setItem("theme", theme);
}

// main page buttons for theme change---
document.getElementById("Classic").addEventListener("click", function() {
    changeThemeColor("#000329","#92A6C0","#5980AD");
    saveTheme("Classic");
});

document.getElementById("Greench").addEventListener("click", function() {
    changeThemeColor("#002D2B","#D2DAE1","#0F795D");
    saveTheme("Greench");
});

document.getElementById("Redania").addEventListener("click", function() {
    changeThemeColor("#841B2D","#EFDFBB","#CB5633");
    saveTheme("Redania");
});
// -------------------------------------
