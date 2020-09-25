(function () {
    var timeSlide = 450;
    var bigNumber = 10000;
    /**
     * 
     * @param {number} number 
     * @return {int} between 0 and number given in param
     */
    var randomInt = function (number) {
        var coef = 10 * number;
        return parseInt(Math.random() * coef);
    }

    var animateCart = function (selector) {
        var arrow = selector.querySelector(".summary-detail-arrow-button");
        var arrowId = "arrrow_" + randomInt(bigNumber);
        var wrapperId = "cart_" + randomInt(bigNumber);
        var wrapper = selector.parentNode;
        arrow.setAttribute("id", arrowId);
        wrapper.setAttribute("id", wrapperId);

        // var isDisplayed = $("#" + wrapperId + " .cart-wrap").css("display") == "block";
        var isDisplayed = $("#checkout_cart").css("display") == "block";
        if (isDisplayed) {
            // $("#" + wrapperId + " .cart-wrap").slideUp(timeSlide);
            $("#checkout_cart").slideUp(TS);
            $("#" + wrapperId + " #" + arrowId).removeClass("summary-detail-arrow-open");
        } else {
            // $("#" + wrapperId + " .cart-wrap").slideDown(timeSlide);
            $("#checkout_cart").slideDown(TS);
            $("#" + wrapperId + " #" + arrowId).addClass("summary-detail-arrow-open");
        }
        arrow.removeAttribute("id");
        wrapper.removeAttribute("id");
    }

    var animateDiscount = function (selector) {
        var arrow = selector.querySelector(".summary-detail-arrow-button");
        var arrowId = "arrrow_" + randomInt(bigNumber);
        var wrapperId = "discount_" + randomInt(bigNumber);
        var wrapper = selector.parentNode;
        arrow.setAttribute("id", arrowId);
        wrapper.setAttribute("id", wrapperId);

        var isDisplayed = $("#" + wrapperId + " .cart-discount-inner").css("display") == "block";
        if (isDisplayed) {
            $("#" + wrapperId + " .cart-discount-inner").slideUp(timeSlide);
            $("#" + wrapperId + " #" + arrowId).removeClass("summary-detail-arrow-open");
        } else {
            $("#" + wrapperId + " .cart-discount-inner").slideDown(timeSlide);
            $("#" + wrapperId + " #" + arrowId).addClass("summary-detail-arrow-open");
        }
        arrow.removeAttribute("id");
        wrapper.removeAttribute("id");
    }


    $(document).ready(function () {


        //—————————————————— CART DOWN ————————————————
        $(".cart-title-block").click(function () {
            // animateCart(this);
            var arrowx = $(this).find(".arrow-element-wrap");
            var shutterx = $("#checkout_cart");
            toggleShutter(shutterx, arrowx);
        });
        //—————————————————— CART UP ————————————————————————
        //—————————————————— DISCOUNT_WINDOW DOWN ————————————————
        $(".discount-title-block").click(function () {
            // animateDiscount(this);
            var arrowx = $(this).find(".arrow-element-wrap");
            var shutterx = $("#discount_body");
            toggleShutter(shutterx, arrowx);
        });
        //—————————————————— DISCOUNT_WINDOW UP ————————————————————————
    });
}).call(this);