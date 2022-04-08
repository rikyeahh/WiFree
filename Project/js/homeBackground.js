// chooses a random home wallpaper every time
var nImage = Math.floor(Math.random() * 8) + 1; // randomize image choice
// build image path
var imgName = "homeImg" + nImage + "Edit.jpg";
var imgPath = "img/homeWallpapers/" + imgName;
// change the background image
document.getElementById("homeImage").style.backgroundImage = "url('" + imgPath + "')";
