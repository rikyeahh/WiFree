// adds functionality to order in descending order the tables when clicking twice on column name
var orderingTitles = document.getElementsByClassName("ordTableColumnLabel"); // table column headings
var url = new URL(window.location.href); // current url
var ord = url.searchParams.get("ord"); // current ord value
for (let a of orderingTitles) { // for each column title, add click functionality
    a.addEventListener("click", function(event) {
        // if user has already clicked on column title (php has aldready redirected to page with $_GET[ord] set)
        if (a.href.includes(ord)) {
            // add DESC to already present URL, redirecting
            event.preventDefault();
            window.location.href = window.location.href + "+DESC";
        }
    });
}
