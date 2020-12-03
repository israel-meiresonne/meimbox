(function () {
    // var TS = 450;
    var animateFilter = function (x) {
        var filterId = "filter_block";
        var isDisplayed = $("#" + filterId).css("display") == "block";
        if (isDisplayed) {
            $("#" + filterId).slideUp(TS);
            evtClose(x);
        } else {
            $("#" + filterId).slideDown(TS);
            evtOpen(x);
        }
    }
    $(document).ready(function () {
        //—————————————————— FILTER ————————————————
        $("#filter_button").click(function () {
            animateFilter(this);
        });
        $("#filter_hide_button").click(function () {
            var filterId = "filter_block";
            $("#" + filterId).slideUp(TS);
        });
        //———————————————————————————————————————————
    });
}).call(this);