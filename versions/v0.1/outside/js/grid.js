(function () {
    // var TS = 450;
    var animateFilter = function (selector) {
        // var wrapper = selector.parentNode.parentNode
        var filterId = "filter_block";
        var isDisplayed = $("#" + filterId).css("display") == "block";
        if (isDisplayed) {
            $("#" + filterId).slideUp(TS);
        } else {
            $("#" + filterId).slideDown(TS);
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