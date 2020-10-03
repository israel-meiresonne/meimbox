(function () {
    reactivate_AnimateInput_Elements = function () {
        $('.input-tag').keyup(function () {
            animateInput(this);
        });
        $('.input-tag').change(function () {
            animateInput(this);
        });
        setInputUnitPosition();
        $(".checkbox-label input").click(function () {
            animateCheckbox(this);
        });
        // $("#filter_minPrice, #filter_maxPrice").change(function () {
        //     updateNumberInputValue(this);
        // });
    }

    reactivate_ChangeInputUnit_Elements = function () {
        $("#add_measure_window .checkbox-container .checkbox-label input").click(function () {
            var target = $("#add_measure_window .measure_input-container-inner .input-unit");
            changeInputUnit(this, target);
        });
    }
    //———————————————————————————— REACTIVATE UP ——————————————————————————————————————————————————
    //———————————————————————————— SHORTCUT DOWN ——————————————————————————————————————————————————

    popAlert = function (m) {
        window.alert(m);
    }

    popAsk = function (m) {
        return window.confirm(m);
    }

    setArticleHeight = function () {
        var textes = $(".detail-text-div");
        var prices = $(".detail-price-div");
        var color = $(".detail-color-div");
        // console.log($(prices[0]).height(500));
        var maxTextes = maxHeight(textes);
        var maxPrices = maxHeight(prices);
        var maxColor = maxHeight(color);
        setHeight(textes, maxTextes)
        setHeight(prices, maxPrices)
        setHeight(color, maxColor)
    }

    maxHeight = function (elements) {
        var nbElement = elements.length;
        var max = 0;
        for (var i = 0; i < nbElement; i++) {
            max = $(elements[i]).height() > max ? $(elements[i]).height() : max;
        }
        return max;
    }

    setHeight = function (elements, height) {
        var nbElement = elements.length;
        for (var i = 0; i < nbElement; i++) {
            $(elements[i]).height(height);
        }
    }

    //———————————————————————————— SHORTCUT UP ————————————————————————————————————————————————————
    //—————————————————————————————————————————————————————————————————————————————————————————————
    var animateSelect = function (selector) {
        try {
            selector.classList.remove("select-error");
            var wrapper = selector.parentNode.parentNode;
            wrapper.getElementsByClassName("comment")[0].innerHTML = null;
        } catch (error) {
            // console.log("No comment");
        }
    }

    animateInput = function (selector) {
        selector.classList.remove("input-error");
        var wrapper = selector.parentNode;

        $(wrapper).find(".comment").slideUp(TS, function () {
            $.text("");
        });

        var container = wrapper.parentNode;

        var containerId = "input_" + randomInt(BNR);
        container.setAttribute("id", containerId);

        var inputTag = container.getElementsByTagName("input")[0];
        if (inputTag.value == '') {
            $("#" + containerId + ' .input-label').slideUp(TS);
            $("#" + containerId + ' input').animate({ padding: '5px' }, TS);
            $("#" + containerId + ' span').animate({ top: '11px' }, TS);
        } else {
            $("#" + containerId + ' .input-label').slideDown(TS);
            $("#" + containerId + ' input').animate({ padding: '1.3em 5px 0' }, TS);
            $("#" + containerId + ' span').animate({ top: '22px' }, TS);
        }
        container.removeAttribute("id");
    }

    updateInputAnimation = function (selector) {
        var a = $(selector);
        // console.log(a);
        var nbA = a.length;
        for (var i = 0; i < nbA; i++) {
            animateInput(a[i]);
        }
    }


    setInputUnitPosition = function () {
        if ($(".input-tag").val() != '') {
            $('.input-wrap label').slideDown(TS);
            $(".input-tag").animate({ padding: '1.3em 5px 0' }, TS);
            $(".input-wrap span").animate({ top: '22px' }, TS);
        }
    }
    updateNumberInputValue = function (x) {
        var val = $(x).val();
        $(x).attr(valueattr, strToFloat(val));

    }
    animateCheckbox = (inpx) => {
        var erx = $(inpx).attr(dataerrorx);
        $(erx).slideUp(TS, () => {
            $.text("");
        })
    }

    animateDropdown = (headx, bodyx) => {
        if (isDisplayed(bodyx)) {
            $(bodyx).slideUp(TS);
            $(headx).addClass("dropdown-arrow-close");
            $(headx).removeClass("dropdown-arrow-open");
        } else {
            $(bodyx).slideDown(TS);
            $(headx).addClass("dropdown-arrow-open");
            $(headx).removeClass("dropdown-arrow-close");
        }
    }

    animateDropdownCheckbox = (inpx, bodyx) => {
        var nm = $(inpx).attr(nameattr);
        var inpid = getId(inpx);
        var ys = $(".dropdown_checkbox-wrap [" + datainputname + "='" + nm + "'][" + dataheadid + "!='" + inpid + "']");
        $(ys).slideUp(TS);
        if (isDisplayed(bodyx)) {
            $(bodyx).slideUp(TS);
        } else {
            $(bodyx).slideDown(TS);
        }
    }

    toggleShutter = (bodyx, arrowx = null) => {
        var arrowx = (!empty(arrowx)) ? arrowx : $(bodyx).attr(dataarrow);
        if (isDisplayed(bodyx)) {
            $(bodyx).slideUp(TS);
            $(arrowx).removeClass("arrow-element-open");
        } else {
            $(bodyx).slideDown(TS);
            $(arrowx).addClass("arrow-element-open");
        }
    }

    selectBody = (headx, bodyx, headsx, bodiesx, headFunc = () => { }, bodyFunc = () => { }, headsFunc = () => { }, bodiesFunc = () => { }) => {
        var bodiesx = $(bodiesx);
        var headsx = $(headsx);
        for (chd of bodiesx) {
            bodiesFunc(chd);
        }
        for (hd of headsx) {
            headsFunc(hd);
        }
        var headx = $(headx);
        var bodyx = $(bodyx);
        headFunc(headx);
        bodyFunc(bodyx);
    }

    toggleSign = (headx , bodyx, headsx, bodiesx) => {
        if(!$(headx).hasClass("sign-head-button-selected")){
            headFunc = (x) => {$(x).addClass("sign-head-button-selected");}
            headsFunc = (x) => {$(x).removeClass("sign-head-button-selected");}
            bodyFunc = (x) => {$(x).slideDown(TS)};
            bodiesFunc =  (x) => {$(x).slideUp(TS)};
            selectBody(headx, bodyx, headsx, bodiesx, headFunc, bodyFunc, headsFunc, bodiesFunc);
        }
    }

    var animateCollapse = function (selector) {
        var collapseDiv = selector.parentNode
        var collapseId = "collapse_" + randomInt(BNR);
        collapseDiv.setAttribute("id", collapseId);

        var wrapper = collapseDiv.parentNode.parentNode.parentNode;
        var wrapperId = "wrapper_" + randomInt(BNR);
        wrapper.setAttribute("id", wrapperId);

        var textDivSelector = "#" + wrapperId + " #" + collapseId + " .collapse-text-div";
        var isDisplayed = $(textDivSelector).css("display") == "block";

        var verticalBarSelector = "#" + wrapperId + " #" + collapseId + " .plus_symbol-vertical";
        if (isDisplayed) {
            $(textDivSelector).slideUp(TS);
            $(verticalBarSelector)[0].className = $(verticalBarSelector)[0].className.replace(/ remove-vertical/g, "");
        } else {
            $(textDivSelector).slideDown(TS);
            $(verticalBarSelector).addClass("remove-vertical");
        }
        collapseDiv.removeAttribute("id");
        wrapper.removeAttribute("id");
    }

    var fitAllSlieder = function () {
        var sliderList = $(".slider-wrap");
        var nbSlider = sliderList.length;
        for (var i = 0; i < nbSlider; i++) {
            fitSlider(sliderList[i]);
        }
        $(".slider-wrap .item-set .silder-ul-container").css("left", "0%");
    }

    var fitSlider = function (selector) {
        // var wrapperId = "#" + selector.getAttribute("id");
        var wrapperId = "slider_" + randomInt(BNR);
        selector.setAttribute("id", wrapperId);

        var nbItemToDisplay = $("#" + wrapperId + " .slider-nb_acticle-width_indicator").width();
        var slideWindowWidth = $("#" + wrapperId + " .slider-window").width();
        var liArticleWidth = slideWindowWidth / nbItemToDisplay;
        var paddingLeft = $("#" + wrapperId + " .item-set .silder-li-container").css("paddingLeft").replace("px", "");
        var paddingRight = $("#" + wrapperId + " .item-set .silder-li-container").css("paddingRight").replace("px", "");
        $("#" + wrapperId + " .item-set .silder-li-container").width(liArticleWidth - paddingLeft - paddingRight);
        var nbArticle = $("#" + wrapperId + " .item-set .silder-li-container").length;
        var ulArticleWidthPercent = (nbArticle * liArticleWidth) / slideWindowWidth * 100;

        var ulSelector = "#" + wrapperId + " .item-set .silder-ul-container";
        $(ulSelector).width(ulArticleWidthPercent + "%");
        selector.removeAttribute("id");
    }

    var slideSliderLeft = function (selector) {
        var wrapper = selector.parentNode;
        // var wrapperId = wrapper.getAttribute("id");
        var wrapperId = "slider_" + randomInt(BNR);
        wrapper.setAttribute("id", wrapperId);
        var nbItemToDisplay = $("#" + wrapperId + " .slider-nb_acticle-width_indicator").width();
        var slideWindowWidth = $("#" + wrapperId + " .slider-window").width();

        var liArticleWidthPercent = 100 / nbItemToDisplay;
        var nbArticle = $("#" + wrapperId + " .item-set .silder-li-container").length;

        var ulSelector = "#" + wrapperId + " .item-set .silder-ul-container";
        var leftPosition = Number.parseFloat($(ulSelector).css("left").replace("px", ""));
        var leftPositionArround = Number.parseFloat((leftPosition + 0.00).toFixed(2));

        if (leftPositionArround >= 0) {
            var newLeftPosition = (-((nbArticle - nbItemToDisplay) * liArticleWidthPercent)) + "%";
            $(ulSelector).animate({ left: newLeftPosition }, TS);
        } else {
            var leftPosPercent = leftPosition / slideWindowWidth * 100;
            var newLeftPosition = leftPosPercent + liArticleWidthPercent + "%";
            $(ulSelector).animate({ left: newLeftPosition }, TS);
        }

        var buttonClass = selector.className.split(" ")[0];
        var slideButton = $("#" + wrapperId + " ." + buttonClass)[0];
        desabledTrueFalse(slideButton, TS);
        wrapper.removeAttribute("id");
    }

    var slideSliderRight = function (selector) {
        var wrapper = selector.parentNode;
        // var wrapperId = wrapper.getAttribute("id");
        var wrapperId = "slider_" + randomInt(BNR);
        wrapper.setAttribute("id", wrapperId);

        var nbItemToDisplay = $("#" + wrapperId + " .slider-nb_acticle-width_indicator").width();
        var slideWindowWidth = $("#" + wrapperId + " .slider-window").width();

        var liArticleWidthPercent = 100 / nbItemToDisplay;
        var nbArticle = $("#" + wrapperId + " .item-set .silder-li-container").length;

        var ulSelector = "#" + wrapperId + " .item-set .silder-ul-container";
        var leftPosition = $(ulSelector).css("left").replace("px", "");
        var ulWidth = $(ulSelector).width();
        var ulArticleWidthPercent = ulWidth / slideWindowWidth * 100;
        var limite = -(ulArticleWidthPercent - nbItemToDisplay * liArticleWidthPercent)
        limite = Number.parseFloat(limite.toFixed(2));

        var leftPosPercent = leftPosition / slideWindowWidth * 100;
        leftPosPercent = Number.parseFloat(leftPosPercent.toFixed(2));

        if (leftPosPercent <= limite) {
            $(ulSelector).animate({ left: "0%" }, TS);
        } else {
            var leftPosPercent = leftPosition / slideWindowWidth * 100;
            var newLeftPosition = leftPosPercent - liArticleWidthPercent + "%";
            $(ulSelector).animate({ left: newLeftPosition }, TS);
        }

        var buttonClass = selector.className.split(" ")[0];
        var slideButton = $("#" + wrapperId + " ." + buttonClass)[0];
        desabledTrueFalse(slideButton, TS);
        wrapper.removeAttribute("id");
    }

    /**
     * Desable the html element passed in param during a time given time
     * @param {htmlElement} selector the element to disable
     * @param {int} time to wait before anable the element
     */
    var desabledTrueFalse = function (selector, time) {
        selector.disabled = true;
        setTimeout(function () {
            selector.disabled = false;
        }, time);
    }

    var animateNewletter = function (selector) {
        var label = selector.parentNode;
        var labelId = "label_" + randomInt(BNR);
        label.setAttribute("id", labelId);

        var targetSelector = "#" + labelId + " .connection-checkbox-text-div";
        var isDisplayed = $(targetSelector).css("display") == "block";

        if (isDisplayed) {
            $(targetSelector).slideUp(TS);
        } else {
            $(targetSelector).slideDown(TS);
        }
        label.removeAttribute("id");
    }

    animatePiano = function (btnId) {
        var selector = $("#" + btnId)[0];
        try {
            // remove class
            var ulButton = selector.parentNode;
            var liButtons = ulButton.getElementsByClassName("piano-li-button");
            var oldSelected = ulButton.getElementsByClassName("piano-selected-button")[0];
            var nbLiButton = liButtons.length;
            var selectorIndex = "";
            var oldSelectedIndex = "";
            for (var i = 0; i < nbLiButton; i++) {
                liButtons[i].className = liButtons[i].className.replace(/ piano-selected-button/g, "");
                selectorIndex = (liButtons[i] == selector) ? i : selectorIndex;
                oldSelectedIndex = (liButtons[i] == oldSelected) ? i : oldSelectedIndex;
            }
            $(selector).addClass("piano-selected-button");

            // slide piano
            var wrapper = ulButton.parentNode.parentNode;
            // console.log(wrapper);
            var ulDisplayable = wrapper.getElementsByClassName("piano-ul-displayable")[0];
            var liDisplayables = ulDisplayable.getElementsByClassName("piano-li-displayable");
            if (liDisplayables[selectorIndex] != liDisplayables[oldSelectedIndex]) {
                $(liDisplayables[oldSelectedIndex]).fadeOut(TS / 2, function () {
                    $(liDisplayables[selectorIndex]).fadeIn(TS / 2);
                });
            }
        } catch (error) {
            console.log(error);
        }
    }


    changeInputUnit = function (selector, target) {
        var unit = $(selector).attr("data-unit");
        $(target).fadeOut(TS, function () {
            $(this).text(unit);
            $(this).fadeIn(TS);
        });
    }

    $(document).ready(function () {
        /*—————————————————— ALL CLICK DOWN —————————————————————————————————*/
        $(document).click(() => {
            console.log(miniPopIsOpen);
            if (miniPopIsOpen) {
                miniPopIsOpen = false;
                displayFadeOut($(".minipop-wrap"));
            }
        })
        /*—————————————————— ALL CLICK UP ———————————————————————————————————*/
        //—————————————————— SELECT DOWN —————————————————
        $('select').change(function () {
            animateSelect(this);
        });
        //———————————————————— SELECT UP ———————————————————————

        //—————————————————— INPUT DOWN —————————————————— 0_REACTIVER_0
        $('.input-tag').keyup(function () {
            animateInput(this);
        });
        $('.input-tag').change(function () {
            animateInput(this);
        });
        setInputUnitPosition();
        $(".checkbox-label input").click(function () {
            animateCheckbox(this);
        });
        // $("#filter_minPrice, #filter_maxPrice").change(function () {
        //     updateNumberInputValue(this);
        // });
        // //———————————————————— INPUT UP ———————————————————————

        /*—————————————————— ARTICLE DOWN ———————————————————————————————————*/
        setArticleHeight();
        /*—————————————————— ARTICLE UP —————————————————————————————————————*/

        //—————————————————— DOPDOWN DOWN ————————————————
        $(".dropdown-head").click(function () {
            // animateDropdown(this);
        });
        //——————————————————— DOPDOWN UP ————————————————————————

        /*——————————————————— DOPDOWN CHECKBOX DOWN —————————————————————————*/
        $('.dropdown_checkbox-head input[type="checkbox"], .dropdown_checkbox-head input[type="radio"]').click(function (e) {
            // animateDropdownCheckbox(this);
        });
        /*——————————————————— DOPDOWN CHECKBOX UP ———————————————————————————*/

        //—————————————————— COLLAPSE DOWN ————————————————
        $(".collapse-title-div").click(function () {
            animateCollapse(this);
        });
        //—————————————————— COLLAPSE UP ————————————————————————

        //—————————————————— SLIDER DOWN————————————————
        fitAllSlieder();
        $(window).resize(function () {
            fitAllSlieder();
        });

        $(".slider-left-button").click(function (e) {
            e.preventDefault();
            slideSliderLeft(this);
        });

        $(".slider-right-button").click(function (e) {
            e.preventDefault();
            slideSliderRight(this);
        });
        //——————————————————— SLIDER UP ————————————————————————

        //—————————————————— NEWLETTER DOWN ————————————————
        $(".newletter-input").click(function () {
            animateNewletter(this);
        });
        //—————————————————— NEWLETTER UP ————————————————————————
        /*—————————————————— SIZE CUSTOMISER DOWN ———————————————————————————*/
        //—— MEASUREMENT INPUT DOWN ——// 0_REACTIVER_0
        $("#measure_adder .checkbox-container .checkbox-label input").click(function () {
            var x = $("#measure_adder .measure_input-container-inner .input-unit");
            changeInputUnit(this, x);
        });
        //—— MEASUREMENT INPUT UP ——//
        /*—————————————————— SIZE CUSTOMISER UP —————————————————————————————*/
    });
}).call(this);