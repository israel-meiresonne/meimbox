(() => {
    // ++++ val down ++++
    var baskettotal = "total";
    var basketsubtotal = "basketsubtotal";
    var basketvat = "vat";
    var basketquantity = "quantity";
    // ++++ attr down ++++
    onclickattr = "onclick";
    idattr = "id";
    // ++++ data- down ++++
    const dadx = "data-dadx";
    const brotherx = "data-brotherx";
    const flagx = "data-flagx";
    const submitbtnx = "data-sbtnx";
    const datatarget = "data-datatarget";
    const submitdata = "data-submitdata";
    popstack = "data-switchstack";
    const basketdata = "data-basket";
    const databefore = "data-before";
    const dataafter = "data-after";
    const dataprodid = "data-" + INPUT_PROD_ID;
    const databoxid = "data-" + KEY_BOX_ID;
    const dataonclick = "data-onclick";
    // closepop = 'data-popdata="closebtn"';
    // ++++ class down ++++
    const selected = "popup-selected";
    disableCls = "standard-button-desabled";
    closebtnCls = "popup_close_btn";
    /*—————————————————— SHORTCUT DOWN ——————————————————————————————————————*/
    empty = (v) => {
        return (v == null || v.length == 0);
    }
    getTag = (x) => {
        return $(x).prop("tagName").toLocaleLowerCase();
    }
    getX = (x) => {
        return (typeof (x) == "string") ? x : "#" + $(x).attr(idattr);
    }
    getCloseButton = (popx) => {
        return $(popx).find("." + closebtnCls);
    }
    getFunc = (a, x) => {
        var f = $(x).attr(a);
        return (!empty(f)) ? f : () => { };
    }
    getStack = (x) => {
        var json = $(x).attr(popstack);
        return (json != null) ? json_decode(json) : [];
    }
    setStack = (x, tab) => {
        var stack = json_encode(tab);
        $(x).attr(popstack, stack);
    }
    enable = function (x) {
        $(x).removeClass(disableCls);
        $(x).attr("disabled", false);
    }
    disable = function (x) {
        $(x).addClass(disableCls);
        $(x).attr("disabled", true);
    }
    removeAnim = function (selector) {
        $(selector).css("overflow", "hidden");
        var h = $(selector).height();
        $(selector).height(h);
        $(selector).animate({ width: '0%' }, TS, function () {
            $(this).slideUp(TS, function () {
                $(this).remove();
            });
        });
    }
    displayFlexOn = (x, t = TS) => {
        $(x).css("opacity", "0");
        $(x).css("display", "flex");
        $(x).animate({ "opacity": "1" }, t);
    }
    displayFlexOff = (x, t = TS) => {
        $(x).animate({ "opacity": "0" }, t, () => {
            $(x).css("display", "none");
        })
    }
    displayFadeIn = (x, t = TS) => {
        $(x).fadeIn(t);
    }
    displayFadeOut = (x, t = TS) => {
        $(x).fadeOut(t);
    }
    replaceFade = function (x, y, t = TS) {
        $(y).css("display", "none");
        $(x).fadeOut(t / 2, function () {
            $(this).replaceWith(y);
            $(y).fadeIn(t);
        });
    }
    fadeValue = (x, v, t = TS) => {
        $(x).fadeOut(t / 2, function () {
            $(this).text(v);
            $(x).fadeIn(t);
        });
    }
    createNone = function (x) {
        var y = $.parseHTML(x);
        $(y).css("display", "none");
        return y;
    }
    /*—————————————————— SHORTCUT UP ————————————————————————————————————————*/
    /*—————————————————— MINI_POPUP BEHAVIOR DOWN ———————————————————————————*/
    openMiniPop = (x, before = () => { }, after = () => { }) => {
        before(x);
        displayFadeIn(x);
        after(x);
        setTimeout(() => {
            miniPopIsOpen = true;
        }, TS)
    }
    /*—————————————————— MINI_POPUP BEHAVIOR UP —————————————————————————————*/
    /*—————————————————— POPUP BEHAVIOR DOWN ————————————————————————————————*/
    openPopUp = function (x, before = () => { }, after = () => { }) {
        before(x);
        var xbtn = $(x).find("." + closebtnCls);
        var idx = getX(x);
        $(xbtn).attr(onclickattr, "closePopUp('" + idx + "')");
        // var stack = json_encode([]);
        // $(xbtn).attr(popstack, stack);
        setStack(xbtn, []);

        $(FCID).fadeIn(TS, function () {
            displayFlexOn(x);
        });
        after(x);
    }
    selectPopUp = (launchx, before = () => { }, after = () => { }) => {
        before(launchx);
        var d = $(launchx).attr(dadx);
        var f = $(launchx).attr(flagx);
        var a = $(f).attr(brotherx);
        var sbtnx = $(d).attr(submitbtnx);
        var ftag = getTag(f);

        var bs = $(d).find(ftag + "[" + brotherx + "='" + a + "']");
        console.log(bs);
        $(bs).removeClass(selected);
        $(f).addClass(selected);

        $(sbtnx).attr(datatarget, f);
        enable(sbtnx);
        console.log(sbtnx);
        after(launchx);
    }
    switchCloseNext = (fromx, tox, before = () => { }, after = () => { }) => {
        before(fromx, tox);
        var tbtn = $(tox).find("." + closebtnCls);
        var idx = getX(tox);
        $(tbtn).attr(onclickattr, "closePopUp('" + idx + "')");
        // var stack = json_encode([]);
        // $(tbtn).attr(popstack, stack);
        setStack(tbtn, []);

        switcher(fromx, tox);
        after(fromx, tox);
    }
    switchPopUp = (fromx, tox, before = () => { }, after = () => { }) => {
        before(fromx, tox)
        var fbtn = $(fromx).find("." + closebtnCls);
        var fevent = $(fbtn).attr(onclickattr);
        var stack = getStack(fbtn);

        var tbtn = $(tox).find("." + closebtnCls);
        $(tbtn).attr(onclickattr, "switchBackPopUp('" + getX(tox) + "', '" + getX(fromx) + "')");
        stack.push(fevent);
        // $(tbtn).attr(popstack, json_encode(stack));
        setStack(tbtn, stack);

        switcher(fromx, tox);
        after(fromx, tox);
    }
    switcher = (fromx, tox) => {
        $(fromx).fadeOut(TS, function () {
            displayFlexOn(tox);
        });
    }
    switchBackPopUp = (fromx, tox, before = () => { }, after = () => { }) => {
        before(fromx, tox)
        var fbtn = $(fromx).find("." + closebtnCls);
        var stack = getStack(fbtn);

        var tbtn = $(tox).find("." + closebtnCls);
        var tevent = stack.pop();
        $(tbtn).attr(onclickattr, tevent);
        // $(tbtn).attr(popstack, json_encode(stack));
        setStack(tbtn, stack);

        switcher(fromx, tox);
        after(fromx, tox);
    }
    closePopUp = function (x, before = () => { }, after = () => { }) {
        before(x);
        $(x).fadeOut(TS, function () {
            $(FCID).fadeOut(TS / 2);
        });
        after(x);
    }
    /*—————————————————— POPUP BEHAVIOR UP ——————————————————————————————————*/
    /*—————————————————— BRAND DOWN ———————————————————————————————————————*/
    selectBrand = (sbtnx) => {
        var x = $(sbtnx).attr(datatarget);
        var brandDatas = json_decode($(x).attr(submitdata));
        var param = mapToParam(brandDatas);
        //build
        var d = {
            "a": A_SELECT_BRAND,
            "d": param,
            "r": selectBrandRSP,
            "l": "#brandPopUp_loading",
            // "x": btnx,
            "sc": () => {
                displayFlexOn(d.l);
                disable(sbtnx);
            },
            "rc": () => {
                displayFlexOff(d.l);
                enable(sbtnx);
            }
        };
        SND(d);
    }
    var selectBrandRSP = function (r) {
        if (r.isSuccess) {
            $("#choose_brand .custom_selected-container").slideUp(TS, function () {
                $(this).html(r.results[BRAND_STICKER_KEY]);
                $(this).slideDown(TS);
            })
            var targer = $("#customize_brand_reference");
            closePopUp(targer);
            var submitBtn = $("#brand_validate_button")[0];
            $(submitBtn).addClass("standard-button-desabled");
            $(submitBtn).attr("disabled", true);
        }
    }
    //—— ADD MEASUREMENT UP ————//
    /*—————————————————— BRAND UP ———————————————————————————————————————————*/
    /*—————————————————— MEASURE MANAGER DOWN ———————————————————————————————*/
    // +++++++++++++++++ shortcut down ++++++++++++++++++++++++++++++++++++++//
    msrMangerLoading_on = function () {
        $("#measurePopUp_loading").css("display", "flex");
        $("#mange_measure_window .customize_measure-content").css("opacity", 0);
    }
    msrMangerLoading_off = function () {
        $("#measurePopUp_loading").css("display", "flex");
        $("#mange_measure_window .customize_measure-content").css("opacity", 1);
    }
    // +++++++++++++++++ qr down ++++++++++++++++++++++++++++++++++++++++++++//
    selectMeasure = (sbtnx) => {
        var x = $(sbtnx).attr(datatarget);
        var brandDatas = json_decode($(x).attr(submitdata));
        var param = mapToParam(brandDatas);
        //build
        var datasSND = {
            "a": A_SELECT_MEASURE,
            "d": param,
            "r": selectMeasureRSP,
            "l": "#measurePopUp_loading",
            // "x": btnx,
            "sc": () => {
                $("#measurePopUp_loading").css("display", "flex");
                $("#mange_measure_window .customize_measure-content").css("opacity", 0);
                disable(sbtnx);
            },
            "rc": cbkRSP = () => {
                $("#measurePopUp_loading").css("display", "flex");
                $("#mange_measure_window .customize_measure-content").css("opacity", 1);
                enable(sbtnx);
            }
        };
        SND(datasSND);
    }
    var selectMeasureRSP = function (r) {
        if (r.isSuccess) {
            $("#measurement_button_div .custom_selected-container").slideUp(TS, function () {
                $(this).html(r.results[MEASURRE_STICKER_KEY]);
                $(this).slideDown(TS);
            })
            var targer = $("#measure_manager");
            closePopUp(targer);
            var submitBtn = $("#measure_select_button")[0];
            $(submitBtn).addClass("standard-button-desabled");
            $(submitBtn).attr("disabled", true);
        }
    }
    removeMsr = function (msr_id) {
        var selector = $("#mange_measure_window .close_button-wrap[data-measure_id='" + msr_id + "']");
        var param_json = $(selector).attr("data-measure");
        var param_map = json_decode(param_json);
        var param = mapToParam(param_map);
        removeMsrDatas = {
            "alert": DELETE_MEASURE_ALERT,
            "nbToWrapper": 4,
            "d": param,
            "a": A_DELETE_MEASURE,
            "r": removeMsrRSP,
            // "lds": "#measurePopUp_loading",
            "l": null,
            "sc": function () { },
            "rc": function () { }
        };
        removeCartElement(selector, removeMsrDatas);
    }
    var removeCartElement = function (selector, datas) {
        if (popAsk(datas.alert)) {
            //build
            var datasSND = {
                "a": datas.a,
                "d": datas.d,
                "r": datas.r,
                "l": datas.l,
                "sc": datas.sc,
                "rc": datas.rc
            };
            SND(datasSND);
        }
    }
    var removeMsrRSP = function (r) {
        if (r.isSuccess) {
            var selector = $("#mange_measure_window .close_button-wrap[data-measure_id='" + r.results[MEASURE_ID_KEY] + "']");
            var wrapper = goToParentNode(selector, removeMsrDatas.nbToWrapper);
            removeAnim(wrapper);
            $("#mange_measure_window .customize_measure-info-div").fadeOut(TS, function () {
                $(this).html(r.results[TITLE_KEY]);
                $(this).fadeIn(TS);
            });
            $("#manager_add_measurement").fadeOut(TS, function () {
                $(this).html(r.results[BUTTON_KEY]);
                $(this).fadeIn(TS);
            });
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    /*—————————————————— MEASURE MANAGER UP —————————————————————————————————*/
    /*—————————————————— MEASURE ADDER DOWN —————————————————————————————————*/
    // ++++ shortcut down ++++
    cleanMsrAdder = () => {
        var measureInput = $("#add_measure_form input[type='text'], #add_measure_form input[type='hidden']");
        $(measureInput).val("");
        $(measureInput).attr("value", null);
        updateInputAnimation(measureInput);
        $("#save_measure_button").attr("onclick", 'addMsr()');
    }
    // +++++++++++++++++ qr down ++++++++++++++++++++++++++++++++++++++++++++//
    addMsr = function () {
        var d = {
            "a": A_ADD_MEASURE,
            "frm": "#add_measure_form input",
            "frmCbk": function () { return ""; },
            "r": addMeasureRSP,
            "l": "#add_measurePopUp_loading",
            "sc": function () {
                $(d.lds).css("display", "flex");
            },
            "rc": function () { }
        };
        frmSND(d);
    }
    var addMeasureRSP = function (r) {
        if (r.isSuccess) {
            $("#add_measurement_button").fadeOut(TS, function () {
                $("#manage_measurement_button").fadeIn(TS);
            });
            $("#measure_manager").html(r.results[QR_MEASURE_CONTENT]);

            var after = () => {
                $("#save_measure_button").removeAttr("onclick");
            }
            switchCloseNext($("#measure_adder"), $("#measure_manager"), after);
        } else {
            var k = Object.keys(r.errors);
            var cbxE = $("#add_measure_form .measure_input-checkbox-conatiner .checkbox_error-div .comment");
            k.forEach(n => {
                var s = $("#add_measure_form .input-tag" + "[name='" + n + "']+.comment");
                addErr(s, r.errors[n].message);
                (n == INPUT_MEASURE_UNIT) ? addErr(cbxE, r.errors[n].message) : "";
                (n == FAT_ERR) ? popAlert(r.errors[n].message) : "";
            });
        }
    }
    updateMsr = function () {
        var d = {
            "a": A_UPDATE_MEASURE,
            "frm": "#add_measure_form input",
            "frmCbk": function () { return ""; },
            "r": updateMsrRSP,
            "l": "#add_measurePopUp_loading",
            "sc": function () {
                $(d.lds).css("display", "flex");
            },
            "rc": function () { }
        };
        frmSND(d);
    }
    var updateMsrRSP = function (r) {
        addMeasureRSP(r);
    }
    getMsrAdder = function (msr_id) {
        var selector = $("#mange_measure_window .cart-element-edit-button[data-measure_id='" + msr_id + "']");
        var param_json = $(selector).attr("data-measure");
        var param_map = json_decode(param_json);
        var param = mapToParam(param_map);
        getMsrAdderDts = {
            // "alert": DELETE_MEASURE_ALERT,
            "nbToWrapper": 5,
            "d": param,
            "a": QR_GET_MEASURE_ADDER,
            "r": getMsrAdderRSP,
            "l": "#measurePopUp_loading",
            "sc": msrMangerLoading_on,
            "rc": msrMangerLoading_off
        };
        SND(getMsrAdderDts);
    }
    var getMsrAdderRSP = function (r) {
        if (r.isSuccess) {
            $("#measure_adder").html(r.results[QR_GET_MEASURE_ADDER]);
            var before = () => { $("#save_measure_button").attr("onclick", 'addMsr()'); }
            switchPopUp($("#measure_manager"), $("#measure_adder"), before);
            var btn = $("#save_measure_button");
            var btnCls = "standard-button-desabled";
            disable(btn, btnCls);
            reactivate_AnimateInput_Elements();
            reactivate_ChangeInputUnit_Elements();
            reactivate_AnableMsrBtn_QR();
            $("#save_measure_button").attr("onclick", 'updateMsr()');
            // $("#save_measure_button").removeAttr("onclick");
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    /*—————————————————— MEASURE ADDER UP ———————————————————————————————————*/
    /*—————————————————— BOX MANAGER DOWN ———————————————————————————————————*/
    getBoxMngr = (conf) => {
        var params = mapToParam({ [A_GET_BX_MNGR]: conf });
        var d = {
            "a": A_GET_BX_MNGR,
            "d": params,
            "r": getBoxMngrRSP,
            "l": "#box_pricing_loading",
            "x": conf,
            "sc": () => { displayFlexOn(d.l) },
            "rc": () => { displayFlexOff(d.l) }
        };
        SND(d);
    }
    var getBoxMngrRSP = (r) => {
        if (r.isSuccess) {
            $("#box_manager_window .pop_up-content-block-inner").html(r.results[A_GET_BX_MNGR]);
            // $("#box_manager_window").html(r.results[A_GET_BX_MNGR]);
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    /*—————————————————— BOX MANAGER UP —————————————————————————————————————*/
    /*—————————————————— PRICING MANAGER DOWN ———————————————————————————————*/
    setAddBoxAfter = () => {
        $(".pricing-wrap .product_add-button-block button").attr(dataafter, 'addBoxAfter');
    }
    addBoxAfter = () => {
        getBasketPop();
        var fromx = "#box_pricing_window";
        var cbtnx = getCloseButton(fromx);
        var tox = "#basket_pop";
        $(cbtnx).attr(onclickattr, "switchCloseNext('" + fromx + "','" + tox + "')");
        $(".pricing-wrap .product_add-button-block button").removeAttr(dataafter);
    }
    addBox = (color, popx, sbtnx) => {
        var param = mapToParam({ [KEY_BOX_COLOR]: color });
        var cbtnx = $(popx).find("." + closebtnCls);
        var before = getFunc(databefore, sbtnx);
        var after = getFunc(dataafter, sbtnx);
        var d = {
            "a": A_ADD_BOX,
            "d": param,
            "r": addBoxRSP,
            "l": "#box_pricing_loading",
            "x": cbtnx,
            "sc": () => { eval(before)(); displayFlexOn(d.l) },
            "rc": () => { eval(after)(); displayFlexOff(d.l) }
        };
        SND(d);
    }
    var addBoxRSP = (r, cbtnx) => {
        if (r.isSuccess) {
            // $("#box_manager_window .pop_up-content-block-inner").html(r.results[A_ADD_BOX]);
            getBoxMngr(CONF_ADD_BXPROD);
            $(cbtnx).click();
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    removeBox = (bxid, x) => {
        if (popAsk(ALERT_DELETE_BOX)) {
            var params = mapToParam({ [KEY_BOX_ID]: bxid });
            var d = {
                "a": A_DELETE_BOX,
                "d": params,
                "r": removeBoxRSP,
                "l": "#basket_pop_loading",
                "x": x,
                "sc": () => { displayFlexOn(d.l) },
                "rc": () => { displayFlexOff(d.l) }
            };
            SND(d);
        }
    }
    var removeBoxRSP = (r, x) => {
        if (r.isSuccess) {
            removeAnim(x);
            basketUpdatePrices(r);
            // getBasketPop();
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        } else if (r.errors[ALERT_DELETE_BOX] != null && r.errors[ALERT_DELETE_BOX] != "") {
            popAlert(r.errors[ALERT_DELETE_BOX].message);
        }
    }
    addBoxProduct = (sbtnx, popx) => {
        var frm = $("#add_prod_form input");
        var x = $(sbtnx).attr(datatarget);
        var bxid = $(x).attr(submitdata);
        var param = mapToParam({ [KEY_BOX_ID]: bxid, [INPUT_PROD_ID]: prodID });
        var cbtnx = $(popx).find("." + closebtnCls);
        var d = {
            "frm": frm,
            "frmCbk": function () {
                return "&" + param;
            },
            "a": A_ADD_BXPROD,
            // "d": param,
            "r": addBoxProductRSP,
            "l": "#box_manager_loading",
            "x": cbtnx,
            "sc": () => {
                displayFlexOn(d.l, TS / 10);
                // $(d.l).css("display", "flex");
                disable(sbtnx);
            },
            "rc": () => {
                // $(d.l).fadeOut(TS);
                displayFlexOff(d.l, TS);
                enable(sbtnx);
            }
        };
        frmSND(d);
    }
    var addBoxProductRSP = (r, cbtnx) => {
        if (r.isSuccess) {
            // $("#box_manager_window .pop_up-content-block-inner").html(r.results[A_ADD_BXPROD]);
            switchCloseNext($("#box_manager_window"), $("#basket_pop"), getBasketPop);
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        } else if (r.errors[A_ADD_BXPROD] != null && r.errors[A_ADD_BXPROD] != "") {
            popAlert(r.errors[A_ADD_BXPROD].message);
        }
    }
    /*—————————————————— PRICING MANAGER UP —————————————————————————————————*/
    /*—————————————————— BASKET MANAGER DOWN ————————————————————————————————*/
    setMoveBoxProduct = (btnx) => {
        var sbtn = $("#sumbit_box_manager");
        var sfunc = $(sbtn).attr(onclickattr);
        $(sbtn).attr(dataonclick, sfunc);

        var func = $(btnx).attr(dataonclick);
        disable(sbtn);
        $(sbtn).attr(onclickattr, func);

        var cbtn = getCloseButton("#box_manager_window");
        var cfunc = $(cbtn).attr(onclickattr);
        var newcfunc = cfunc + ";unsetMoveBoxProduct()";
        $(cbtn).attr(onclickattr, newcfunc);
    }
    unsetMoveBoxProduct = () => {
        var sbtn = $("#sumbit_box_manager");
        disable(sbtn);
        var sfunc = $(sbtn).attr(dataonclick);
        $(sbtn).attr(onclickattr, sfunc);
        $(sbtn).removeAttr(dataonclick);
    }
    getBasketPop = () => {
        var d = {
            "a": A_GET_BSKT_POP,
            "d": null,
            "r": getBasketPopRSP,
            "l": "#basket_pop_loading",
            // "x": cbtnx,
            "sc": () => { displayFlexOn(d.l) },
            "rc": () => { displayFlexOff(d.l) }
        };
        SND(d);
    }
    basketUpdatePrices = (r) => {
        if (r.isSuccess) {
            var ttx = $("[" + basketdata + "='" + baskettotal + "']");
            var ttv = r.results[KEY_TOTAL];
            fadeValue(ttx, ttv);

            var sbtx = $("[" + basketdata + "='" + basketsubtotal + "']");
            var sbtv = r.results[KEY_SUBTOTAL];
            fadeValue(sbtx, sbtv);

            var vatx = $("[" + basketdata + "='" + basketvat + "']");
            var vatv = r.results[KEY_TOTAL];
            fadeValue(vatx, vatv);

            var qtyx = $("[" + basketdata + "='" + basketquantity + "']");
            var qtyv = r.results[KEY_BSKT_QUANTITY];
            fadeValue(qtyx, qtyv);
        }
    }
    var getBasketPopRSP = (r) => {
        if (r.isSuccess) {
            $("#basket_pop .pop_up-content-block-inner").html(r.results[A_GET_BSKT_POP]);
            basketUpdatePrices(r);
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    moveBoxProduct = (bxid, pid, seq) => {
        var targetx = $("#sumbit_box_manager").attr(datatarget);
        var newbxid = $(targetx).attr(submitdata);
        var map = {
            [KEY_BOX_ID]: bxid,
            [KEY_NEW_BOX_ID]: newbxid,
            [KEY_PROD_ID]: pid,
            [KEY_SEQUENCE]: seq,
        }
        var params = mapToParam(map);
        var d = {
            "a": A_MV_BXPROD,
            "d": params,
            "r": moveBoxProductRSP,
            "l": "#box_manager_loading",
            // "x": cbtnx,
            "sc": () => { displayFadeIn(d.l) },
            "rc": () => { displayFadeOut(d.l) }
        };
        SND(d);
    }
    moveBoxProductRSP = (r) => {
        if (r.isSuccess) {
            getBasketPop();
            var cbtn = getCloseButton("#box_manager_window");
            $(cbtn).click();
        } else if (!empty(r.errors[FAT_ERR])) {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    /*—————————————————— BASKET MANAGER UP ——————————————————————————————————*/


    $(document).ready(() => {
        /*—————————————————— BRAND DOWN ———————————————————————————————————————*/
        //—— ADD MEASUREMENT DOWN ——// 0_REACTIVER_0
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
        //—— ADD MEASUREMENT UP ————//
        /*—————————————————— BRAND UP ———————————————————————————————————————————*/
    })
}).call(this)