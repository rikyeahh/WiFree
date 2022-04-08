// changes css variables to match chosen theme
function changeThemeColor(primary, secondary, others) {
    var root = document.documentElement;
    root.style.setProperty("--primary-color", primary);
    root.style.setProperty("--secondary-color", secondary);
    root.style.setProperty("--others-color", others);
}

// self-invokes to check localStorage, then applies chosen theme
(function () {
  var theme = localStorage.getItem("theme");

  switch (theme) {
    case "Greench":
      changeThemeColor("#002D2B","#D2DAE1","#0F795D");
      break;

    case "Redania":
      changeThemeColor("#841B2D","#EFDFBB","#CB5633");
      break;

    default: /*to Classic*/
      changeThemeColor("#000329","#92A6C0","#5980AD");
  }
})();
