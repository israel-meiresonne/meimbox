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
    /*———————————————————————————— SIGN DOWN ————————————————————————————————*/
    signUp = (formx, sbtnx) => {
        var frm = $(formx).find("input");
        var d = {
            "frm": frm,
            "frmCbk": () => { },
            "a": A_SIGN_UP,
            "r": signUpRSP,
            "l": ".sign_form-loading",
            "x": { "sbtnx": sbtnx, "formx": formx },
            "sc": () => {
                displayFlexOn(d.l, TS / 10);
                disable(sbtnx);
            },
            "rc": () => {
                displayFlexOff(d.l, TS);
                enable(sbtnx);
            }
        };
        frmSND(d);
    }
    const signUpRSP = (r, x) => {
        if (r.isSuccess) {
            window.location.assign(window.location.href);
        } else {
            handleErr(r, x.formx);
        }
    }

    signIn = (formx, sbtnx) => {
        var frm = $(formx).find("input");
        var d = {
            "frm": frm,
            "frmCbk": () => { },
            "a": A_SIGN_IN,
            "r": signInRSP,
            "l": ".sign_form-loading",
            "x": { "sbtnx": sbtnx, "formx": formx },
            "sc": () => {
                displayFlexOn(d.l, TS / 10);
                disable(sbtnx);
            },
            "rc": () => {
                displayFlexOff(d.l, TS);
                enable(sbtnx);
            }
        };
        frmSND(d);
    }
    const signInRSP = (r, x) => {
        signUpRSP(r, x);
        // if (r.isSuccess) {
        //     window.location.assign(window.location.href);
        // } else {
        //     handleErr(r, x.formx);
        // }
    }
    /*———————————————————————————— SIGN UP ——————————————————————————————————*/
    /*———————————————————————————— ADDRESS DOWN —————————————————————————————*/
    getAddressesSet = () => {
        var d = {
            "a": QR_GET_ADRS_SET,
            "d": null,
            "r": getAddressesSetRSP,
            "l": "#address_set_recipient_loading",
            // "x": cbtnx,
            "sc": () => { displayFlexOn(d.l) },
            "rc": () => { displayFlexOff(d.l) }
        };
        SND(d);
    }
    const getAddressesSetRSP = (r) => {
        if (r.isSuccess) {
            // $(".address-set-recipient").css("display", "none");
            $(".address-set-recipient").html(r.results[QR_GET_ADRS_SET]);
        } else {
            handleErr(r, x.formx);
        }
    }
    addAddress = (formx, sbtnx, conf) => {
        var frm = $(formx).find("input");
        var d = {
            "frm": frm,
            "frmCbk": () => { },
            "a": QR_ADD_ADRS,
            "r": addAddressRSP,
            "l": "#address_form_loading",
            "x": { "formx": formx, "conf": conf },
            "sc": () => {
                displayFlexOn(d.l, TS / 10);
                disable(sbtnx);
            },
            "rc": () => {
                displayFlexOff(d.l, TS);
                enable(sbtnx);
            }
        };
        frmSND(d);
    }
    const addAddressRSP = (r, x) => {
        if (r.isSuccess) {
            getAddressesSet();
            var inpx = $(x.formx).find("input[type!=radio]");
            cleanInput(inpx);
            switch (x.conf) {
                case CONF_ADRS_FEED:
                    $(".address-form-container").fadeOut(TS, () => {
                        $(".address-set-recipient").fadeIn(TS, () => {
                            $(".address-form-container").remove();
                        });
                    });
                    break;
                case CONF_ADRS_POP:
                    $(".address-set-recipient").fadeIn(TS);
                    $("#addaddress_form_close_pop").click();
                    break;
            }
        } else {
            handleErr(r, x.formx);
        }
    }
    selectAddress = (sbtnx) => {
        var x = $(sbtnx).attr(datatarget);
        var val = $(x).attr(submitdata);
        var map = {[KEY_ADRS_SEQUENCE]:val}
        var params = mapToParam(map);
        var d = {
            "a": QR_SELECT_ADRS,
            "d": params,
            "r": selectAddressRSP,
            "l": "#address_set_recipient_loading",
            // "x": cbtnx,
            "sc": () => { displayFlexOn(d.l) },
            "rc": () => { displayFlexOff(d.l) }
        };
        SND(d);
    }
    const selectAddressRSP = (r) => {
        if (r.isSuccess) {
            // console.log("success");
            window.location.assign(r.results[QR_SELECT_ADRS]);
        } else {
            // console.log("error");
            handleErr(r, x.formx);
        }
    }
    /*———————————————————————————— ADDRESS UP ———————————————————————————————*/
    /*———————————————————————————— COUNTTRY DOWN ————————————————————————————*/
    updateCountry = (frmx) => {
        var frm = $(frmx).find("input");
        var d = {
            "frm": frm,
            "frmCbk": () => { },
            "a": QR_UPDATE_COUNTRY,
            "r": updateCountryRSP,
            "l": "#nada",
            "x": null,
            "sc": () => {
                displayFlexOn(d.l, TS / 10);
            },
            "rc": () => {
                displayFlexOff(d.l, TS);
            }
        };
        frmSND(d);
    }
    const updateCountryRSP = (r) => {
        if (r.isSuccess) {
            console.log("success");
            // basketUpdateDatas(r);
            getBasketPop();
        } else {
            console.log("error");
            handleErr(r, x.formx);
        }
        
    }
    /*———————————————————————————— COUNTTRY UP ——————————————————————————————*/
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