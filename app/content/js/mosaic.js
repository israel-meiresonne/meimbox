(() => {
    rz = null;
    // initPos = (bx) => {
    //     var xs = $(bx);
    //     var i = 0;
    //     for (x of xs) {
    //         $(x).attr(idattr, "id"+i);
    //         i++;
    //     }
    // }
    infinitySlide = (px, bx) => {
        if (isDisplayed(px)) {
            var bxs = $(bx);
            if (bxs.length >= 3) {
                var f = bxs[0];
                $(bx).css("right", 0);
                var fw = $(f).width();
                var r = fw;
                var T = fw / 25;
                // var T = fw / 500;
                var bz = "cubic-bezier(.32,.36,.69,.71)";
                $(bx).css("transition", T + "s " + bz);
                $(bx).css("-moz-transition", T + "s " + bz);
                $(bx).css("right", r);

                setTimeout(() => {
                    $(bx).css("transition", "none");
                    $(bx).css("-moz-transition", "none");
                    $(px)[0].appendChild(f);
                    infinitySlide(px, bx);
                }, T * 1000);
            }
        }
        // if(empty(rz)){
        //     $(window).resize(() => {
                
        //     });
        // }
    }
    $(document).ready(() => {
        infinitySlide(".feature_content-mosaic_computer", ".computer_mosaic")
        infinitySlide(".feature_content-mosaic_mobile", ".mobile_mosaic")
        // initPos(".computer_mosaic");
        // initPos(".mobile_mosaic");
    });
}).call(this)