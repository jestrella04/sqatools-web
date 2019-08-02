if (window.location.protocol == "http:") {
    var currentUrl = window.location.href.substr(5);
    var secureUrl  = "https:" + currentUrl;

    window.location.replace(secureUrl);
}

var currentYear = new Date().getFullYear();

$("#current-year").html(currentYear);
$('[data-toggle="tooltip"]').tooltip();

$(".close").on("click", function () {
    $("#alert").hide();
});