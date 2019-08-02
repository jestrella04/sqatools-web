$(".list-group-item").on("click", function () {
    var server = $("#server").val();
    var plugin = $("#plugin").val();
    var file = $(this).attr("id");
    var webpayPhp = $(this).attr("data-urlwebpay");

    $("#alert").hide();
    $("#script").attr("disabled", "disabled");
    $("#webpay-response").hide();
    $(".list-group-item").removeClass("list-group-item-primary");
    $(this).addClass("list-group-item-primary");
    $("#webpay-url").val("");

    if ("" == server || "" == plugin) {
        $("#alert").show();
    } else {
        var paramsUrl = "html/" + file + ".php";
        var urlBase = document.URL.substr(0, document.URL.lastIndexOf("/"));
        var urlTail = webpayPhp + "/" + server + "/" + plugin + "/" + file + ".html";
        var url = urlBase + "/" + urlTail;

        $.get(paramsUrl, function (data) {
            $("#script-source-body").text(data);
        });

        $("#script").removeAttr("disabled");
        $("#webpay").attr("src", urlTail);
        $("#webpay-url").val(url);
    }
});