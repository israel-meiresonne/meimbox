(function () {
    reactivate_AnableMsrBtn_QR = function () {
        $("#add_measure_form .checkbox-label input").click(function () {
            var selector = $("#save_measure_button");
            var btnCls = "standard-button-desabled";
            enable(selector, btnCls);
        });
        $("#add_measure_form input").keyup(function () {
            var selector = $("#save_measure_button");
            var btnCls = "standard-button-desabled";
            enable(selector, btnCls);
        });

        // var enable = function (selector, btnCls) {
        //     $(selector).removeClass(btnCls);
        //     $(selector).attr("disabled", false);
        // }

        // var disable = function (selector, btnCls) {
        //     $(selector).addClass(btnCls);
        //     $(selector).attr("disabled", true);
        // }
        // $("#add_measure_form input").keydown(function (e) {
        //     ctrEtr(e, frmSND, saveMsrDts);
        // });
    }
    //———————————————————————————— REACTIVATE UP ——————————————————————————————————————————————————
    //———————————————————————————— SHORTCUT DOWN ——————————————————————————————————————————————————
    const getCol = function () {
        var d = "";
        var i = 0;
        var c = $_GET["collections"] ? $_GET["collections"].split(",") : [];
        c.forEach(element => {
            d += "&collections_" + i + "=" + element
            i++;
        });
        return d;
    }
    var ctrEtr = function (e, f, dts) {
        if ((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)) {
            f(dts);
        }
    }
    addErr = function (s, err) {
        $(s).text(err);
        $(s).slideDown(TS);
    }
    //———————————————————————————— SHORTCUT UP ————————————————————————————————————————————————————
    //—————————————————————————————————————————————————————————————————————————————————————————————

    var filterRSP = function (r) {
        if (r.isSuccess) {
            $(".search-sticker-block .sticker-set").fadeOut(TS, function () {
                $(".search-sticker-block .sticker-set").html(r.results[GRID_STICKERS_KEY]);
            });
            $(".search-sticker-block .sticker-set").fadeIn(TS);
            $(".item-space .remove-ul-default-att").html(r.results[GRID_CONTENT_KEY]);
            setArticleHeight();
        } else {
            console.log("error: ", r);
        }
    }

    removeSticker = function (stickerVal) {
        var stickerSpan = $('.sticker-wrap .sticker-content-div[value="' + stickerVal + '"]')[0];
        var wrapperParent = stickerSpan != null ? stickerSpan.parentNode.parentNode.parentNode.parentNode : null;
        var classes = wrapperParent != null ? wrapperParent.classList : [];
        // var found = false;
        classes.forEach(className => {
            switch (className) {
                case "search-sticker-div":
                    var isCheckbox = false;
                    var checkedSelector = $('#grid_filter .checkbox-label input[value="' + stickerVal + '"]')[0];
                    isCheckbox = checkedSelector != null ? !(checkedSelector.checked = false) : false;

                    var isNumber = false;
                    var filledInput = isCheckbox ? null : $('#grid_filter input[type="number"][value="' + stickerVal + '"]')[0]
                    isNumber = filledInput != null ? !(filledInput.value = "") : false;

                    if (isNumber) {
                        var numberInputWrapper = filledInput.parentNode;
                        var numberInputWrapperId = "number_Input_" + randomInt(BNR);
                        numberInputWrapper.setAttribute("id", numberInputWrapperId);
                        $("#" + numberInputWrapperId + ' label').slideUp(TS);
                        $("#" + numberInputWrapperId + ' input').animate({ padding: '5px' }, TS);
                    }
                    isCheckbox || isNumber ? frmSND(filterDatas) : "";
                    break;
            }
        });
    }
    checkBoxProductStock = (frmx) => {
        // e.preventDefault();
        // var frm = $("#form_check_prod_stock input");
        var frm = $(frmx).find("input");
        var d = {
            "frm": frm,
            "frmCbk": () => { },
            // "frmCbk": function () {
            //     return "&" + INPUT_PROD_ID + "=" + prodID;
            // },
            "a": A_SBMT_BXPROD,
            "r": addProdRSP,
            "l": "#add_prod_loading",
            "sc": () => { $(d.l).css("display", "flex") },
            "rc": () => { displayFadeOut(d.l) }
        };
        frmSND(d);
    }
    var addProdRSP = function (r) {
        if (r.isSuccess) {
            getBoxMngr(CONF_ADD_BXPROD);
            before = () => { disable("#sumbit_box_manager"); }
            openPopUp("#box_manager_window", before);
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }

    $(document).ready(function () {
        /*———————————————————————— FILTER POST DOWN —————————————————————————*/
        $("#grid_filter .checkbox-label input").click(function () {
            frmSND(filterDatas);
        });
        // $("#grid_filter .apply-button-container button").click(function () {
        $("#grid_filter #filter_button").click(function () {
            frmSND(filterDatas);
        });

        filterDatas = {
            "frm": "#grid_filter input",
            "frmCbk": getCol,
            "a": QR_FILTER,
            "r": filterRSP,
            "l": "#prodGrid_loading",
            "sc": function () { },
            "rc": function () { }
        }
        /*———————————————————————— FILTER POST UP ———————————————————————————*/
        /*—————————————————— ADD PRODUCT DOWN ———————————————————————————————*/
        /*———— sumbit sizes down ————*/
        // $("#select_size_for_box").click(function (e) {
        //     e.preventDefault();
        //     var frm = $("#form_check_prod_stock input");
        //     var datas = {
        //         "frm": frm,
        //         "frmCbk": function () {
        //             return "&" + INPUT_PROD_ID + "=" + prodID;
        //         },
        //         "a": A_SBMT_BXPROD,
        //         "r": addProdRSP,
        //         "l": "#add_prod_loading",
        //         "sc": addProdFlex_on,
        //         "rc": function () { }
        //     };
        //     frmSND(datas);
        // });
        // var addProdFlex_on = function () {
        //     $("#add_prod_loading").css("display", "flex");
        // }
        /*———— sumbit sizes up ———*/
        /*—————————————————— ADD PRODUCT UP —————————————————————————————————*/



    });
}).call(this);