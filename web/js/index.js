window.onload = function() {
    var numtrows = document.getElementsByTagName("tr").length;

    if (numtrows > 4) {
        document.body.style.display="block";
    } else {
        var baddir = window.location.pathname;
        window.location = "/error.php?error=403&euri=" + baddir;
    }
};

