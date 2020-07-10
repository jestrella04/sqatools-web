$(".list-group-item").on("click", function () {
    var server = $("#server").val();
    var plugin = $("#plugin").val();
    var recaptcha = $('#recaptcha').val();
    var file = $(this).attr("id");
    var options = $(this).attr("data-targeturl");

    if ("object" == plugin) {
        options = options + "+object";
    }

    $("#alert").hide();
    $("#script").attr("disabled", "disabled");
    $("#webpay").empty();
    $("#webpay-response").empty();
    $(".list-group-item").removeClass("list-group-item-primary");
    $(this).addClass("list-group-item-primary");
    $("#webpay-url").val("");

    if ("" === server || "" === plugin || "" === recaptcha) {
        $("#alert").show();
    } else {
        var paramsUrl = "html/" + file + ".php";
        var urlBase = document.URL.substr(0, document.URL.lastIndexOf("/"));
        var urlTail = "swp.php/" + server + "/" + options + "+recaptcha" + recaptcha + "/" + file + ".php";
        var url = urlBase + "/" + urlTail;

        $.get(paramsUrl, function (data) {
            $("#script-source-body").text(data);
        });

        $("#script").removeAttr("disabled");
        $("#webpay").attr("src", urlTail);
        $("#webpay-url").val(url);
    }
});