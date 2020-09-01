(function () {
    // var TS = 450;
    // var fadeOn = function (x, t = TS) {
    //     if (!($(x).css("display") == "block")) {
    //         $(x).addClass("zoom_in");
    //         $(x).fadeIn(t, function () {
    //             $(this).removeClass("zoom_in");
    //         });
    //     }
    // }
    // var fadeOff = function (x, t = TS) {
    //     if (($(x).css("display") == "block")) {
    //         $(x).addClass("zoom_out");
    //         $(x).fadeOut(t, function () {
    //             $(this).removeClass("zoom_out");
    //         });
    //     }
    // }
    $(document).ready(function () {
        $(".size-set-container .checkbox-label input").click(function () {
            $(".brand-custom-container").slideDown(TS);
        });
        $("#char_size, #customize_size").click(function () {
            var c = $(this).attr("data-x");
            var x = $("." + c + " .dropdown_checkbox-checkbox-list");
            $(x).slideUp(TS);
        });
    });
}).call(this);