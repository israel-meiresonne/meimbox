(() => {
    // ++++ val down ++++
    const basketsumprods = "sum_prods";
    const baskettotal = "total";
    const basketsubtotal = "subtotal";
    const basketproddiscount = "prod_discount";
    const basketvat = "vat";
    const basketshipping = "shipping";
    const basketshipdiscount = "ship_discount";
    const basketdelivery = "delivery";
    const basketfreeshipping = "free_shipping";
    const basketquantity = "quantity";
    const basketboxrate = "boxrate";
    // ++++ class down ++++
    const selected = "popup-selected";
    disableCls = "standard-button-desabled";
    closebtnCls = "popup_close_btn";
    const submitCls = "submit_btn_cls";
    // ++++ attr down ++++
    idattr = "id";
    nameattr = "name";
    onclickattr = "onclick";
    valueattr = "value";
    // ++++ data- down ++++
    const dadx = "data-dadx";
    databrotherx = "data-brotherx";
    const flagx = "data-flagx";
    const submitbtnx = "data-sbtnx";
    datatarget = "data-datatarget";
    submitdata = "data-submitdata";
    popstack = "data-switchstack";
    const basketdata = "data-basket";
    const databefore = "data-before";
    const dataafter = "data-after";
    const datasuccess = "data-success";
    const dataprodid = "data-" + KEY_PROD_ID;
    const databoxid = "data-" + KEY_BOX_ID;
    const dataonclick = "data-onclick";
    datainputname = "data-inputname";
    dataheadid = "data-headid";
    const datavase = "data-vase";
    dataarrow = "data-arrow";
    dataerrorx = "data-errorx";
    dataerrortype = "data-errortype";
    datalx = "data-loadingx"
    dataisdisplayed = "data-isdisplayed";
    /*—————————————————— SHORTCUT DOWN ——————————————————————————————————————*/
    empty = (v) => {
        return (v == null || v == "");
    }
    getTag = (x) => {
        return $(x).prop("tagName").toLocaleLowerCase();
    }
    getX = (x) => {
        return (typeof (x) == "string") ? x : "#" + $(x).attr(idattr);
    }
    getId = (x) => {
        return $(x).attr(idattr);
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
    getKeys = (obj) => {
        return Object.keys(obj);
    }
    setStack = (x, tab) => {
        var stack = json_encode(tab);
        $(x).attr(popstack, stack);
    }
    enable = function (x, t = 0) {
        setTimeout(() => {
            $(x).removeClass(disableCls);
            $(x).attr("disabled", false);
        }, t * 1000);
    }
    disable = function (x) {
        $(x).addClass(disableCls);
        $(x).attr("disabled", true);
    }
    pushFunc = (x, f) => {
        var xf = $(x).attr(onclickattr);
        var newxf = xf + ";" + f;
        $(x).attr(onclickattr, newxf);
    }
    removeAnim = (x) => {
        $(x).css("overflow", "hidden");
        var h = $(x).height();
        $(x).height(h);
        $(x).animate({ width: '0%' }, TS, function () {
            $(this).slideUp(TS, function () {
                $(this).remove();
            });
        });
    }
    isDisplayed = (x) => {
        return !($(x).css("display") == "none");
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
    handleErr = (r, frmx = null) => {
        var k = Object.keys(r.errors);
        k.forEach(n => {
            var inpx = $(frmx).find("[name='" + n + "']");
            var erx = $(inpx).attr(dataerrorx);
            var erType = $(inpx).attr(dataerrortype);
            switch (erType) {
                case ER_TYPE_COMMENT:
                    addErr(erx, r.errors[n].message);
                    break;
                case ER_TYPE_MINIPOP:
                    var cx = $(erx).find(".comment");
                    $(cx).html(r.errors[n].message);
                    openMiniPop(erx);
                    break;
            }
        });
        if (!empty(r.errors[FAT_ERR])) {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    handleFbPxl = (r) => {
        eval(r.results[KEY_FB_PXL]);
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
    createNone = (x) => {
        var y = $.parseHTML(x);
        $(y).css("display", "none");
        return y;
    }
    cleanInput = (inpx) => {
        $(inpx).val("");
        $(inpx).keyup();
    }
    switchClass = (x, rmv, add) => {
        $(x).removeClass(rmv);
        $(x).addClass(add);
    }
    paramToObj = (p) => {
        return JSON.parse('{"' + decodeURI(p).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}')
    }
    myTimeOut = (f, t = 1) => {
        setTimeout(() => {
            f();
        }, t * 1000);
    }
    /*—————————————————— SHORTCUT UP ————————————————————————————————————————*/
    /*—————————————————— MINI_POPUP BEHAVIOR DOWN ———————————————————————————*/
    openMiniPop = (x, before = () => { }, after = () => { }) => {
        var isd = $(x).attr(dataisdisplayed) == "true";
        if (!isd) {
            before(x);
            displayFadeIn(x, TS);
            after(x);
            setTimeout(() => {
                $(x).attr(dataisdisplayed, true);
            }, TS)
        }
    }
    /*—————————————————— MINI_POPUP BEHAVIOR UP —————————————————————————————*/
    /*—————————————————— POPUP BEHAVIOR DOWN ————————————————————————————————*/
    openPopUp = function (x, before = () => { }, after = () => { }) {
        before(x);
        var xbtn = $(x).find("." + closebtnCls);
        var idx = getX(x);
        $(xbtn).attr(onclickattr, "closePopUp('" + idx + "')");
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
        var a = $(f).attr(databrotherx);
        var sbtnx = $(d).attr(submitbtnx);
        var ftag = getTag(f);

        var bs = $(d).find(ftag + "[" + databrotherx + "='" + a + "']");
        $(bs).removeClass(selected);
        $(f).addClass(selected);

        $(sbtnx).attr(datatarget, f);
        enable(sbtnx);
        retreiveEvt(launchx);
        after(launchx);
    }
    switchCloseNext = (fromx, tox, before = () => { }, after = () => { }) => {
        before(fromx, tox);
        var tbtn = $(tox).find("." + closebtnCls);
        var idx = getX(tox);
        $(tbtn).attr(onclickattr, "closePopUp('" + idx + "')");
        setStack(tbtn, []);

        switcher(fromx, tox);
        after(fromx, tox);
    }
    transferPopBehavior = (fromx, tox, before = () => { }, after = () => { }) => {
        before(fromx, tox);
        var fbtn = getCloseButton(fromx);
        var fevent = $(fbtn).attr(onclickattr);
        var tevent = fevent.replace(getX(fromx), getX(tox));
        var stackjson = $(fbtn).attr(popstack);
        var tstackjson = stackjson.replace(getX(fromx), getX(tox));

        var tbtn = getCloseButton(tox);
        $(tbtn).attr(onclickattr, tevent);
        $(tbtn).attr(popstack, tstackjson);
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
        evtClose(fromx);
        after(fromx, tox);
    }
    closePopUp = function (x, before = () => { }, after = () => { }) {
        before(x);
        $(x).fadeOut(TS, function () {
            $(FCID).fadeOut(TS / 2);
        });
        evtClose(x);
        after(x);
    }
    /*—————————————————— POPUP BEHAVIOR UP ——————————————————————————————————*/
    /*—————————————————— BRAND DOWN ———————————————————————————————————————*/
    setSelectBrandItemPage = () => {
        $("#brand_validate_button").attr(datavase, "#form_check_prod_stock .brand-custom-container .custom_selected-container");
    }
    setSelectBrandSizeEditor = () => {
        $("#brand_validate_button").attr(datavase, "#form_edit_prod_size .brand-custom-container .custom_selected-container");
    }
    selectBrand = (sbtnx) => {
        var x = $(sbtnx).attr(datatarget);
        var j = $(x).attr(submitdata);
        var o = json_decode(j);
        var param = mapToParam(o);
        var vx = $($(sbtnx).attr(datavase));
        evt('evt_cd_90', j);
        var d = {
            "a": A_SELECT_BRAND,
            "d": param,
            "r": selectBrandRSP,
            "l": "#brandPopUp_loading",
            "x": vx,
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
    var selectBrandRSP = function (r, vx) {
        if (r.isSuccess) {
            var stk = createNone(r.results[BRAND_STICKER_KEY]);
            $(vx).slideUp(TS, function () {
                $(vx).html(stk);
                $(vx).slideDown(TS / 10, () => {
                    $(stk).slideDown(TS);
                });
            })
            var cbtn = getCloseButton("#customize_brand_reference");
            $(cbtn).click();
            disable("#brand_validate_button");
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
    setSelectMeasureItemPage = () => {
        $("#measure_select_button").attr(datavase, "#form_check_prod_stock .customize_choice-button-block .custom_selected-container");
    }
    setSelectMeasureSizeEditor = () => {
        $("#measure_select_button").attr(datavase, "#form_edit_prod_size .customize_choice-button-block .custom_selected-container");
    }
    // +++++++++++++++++ qr down ++++++++++++++++++++++++++++++++++++++++++++//
    selectMeasure = (sbtnx) => {
        var x = $(sbtnx).attr(datatarget);
        var j = $(x).attr(submitdata);
        var brandDatas = json_decode(j);
        var param = mapToParam(brandDatas);
        var vx = $($(sbtnx).attr(datavase));
        evt('evt_cd_102', j);
        var datasSND = {
            "a": A_SELECT_MEASURE,
            "d": param,
            "r": selectMeasureRSP,
            "l": "#measurePopUp_loading",
            "x": vx,
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
    var selectMeasureRSP = function (r, vx) {
        if (r.isSuccess) {
            var stk = createNone(r.results[MEASURRE_STICKER_KEY]);
            $(vx).slideUp(TS, function () {
                $(vx).html(stk);
                $(vx).slideDown(TS / 10, () => {
                    $(stk).slideDown(TS);
                });
            })
            var cbtn = getCloseButton("#measure_manager");
            $(cbtn).click();
            disable("#measure_select_button");
        }
    }
    removeMsr = function (x) {
        var j = $(x).attr("data-measure");
        var o = json_decode(j);
        var p = mapToParam(o);
        removeMsrDatas = {
            "alert": DELETE_MEASURE_ALERT,
            "nbToWrapper": 4,
            "d": p,
            "a": A_DELETE_MEASURE,
            "r": removeMsrRSP,
            "x": { "x": x },
            "l": null,
            "sc": function () { },
            "rc": function () { }
        };
        removeCartElement(x, removeMsrDatas);
    }
    var removeCartElement = function (x, d) {
        if (popAsk(d.alert)) {
            evt('evt_cd_95', json_encode(paramToObj(d.d)));
            var dSND = {
                "a": d.a,
                "d": d.d,
                "r": d.r,
                "x": { "x": x },
                "l": d.l,
                "sc": d.sc,
                "rc": d.rc
            };
            SND(dSND);
        }
    }
    var removeMsrRSP = function (r, x) {
        if (r.isSuccess) {
            var wrapper = goToParentNode(x.x, removeMsrDatas.nbToWrapper);
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
    setCbtnAdderMsr = () => {
        datasuccess
        var cbtnx = getCloseButton("#measure_adder");
        var fromx = "#measure_adder";
        var tox = "#measure_manager";
        $(cbtnx).attr(onclickattr, "switchCloseNext('" + fromx + "','" + tox + "')");
        console.log(cbtnx);
    }
    setAddMsr = () => {
        var measureInput = $("#add_measure_form input[type='text'], #add_measure_form input[type='hidden']");
        $(measureInput).val("");
        $(measureInput).attr("value", null);
        updateInputAnimation(measureInput);
        $("#save_measure_button").attr("onclick", 'addMsr()');
        vaseTransfer();
    }
    setUpdateMsr = () => {
        $("#save_measure_button").attr(onclickattr, 'updateMsr()');
        vaseTransfer();
    }
    vaseTransfer = () => {
        var vx = $("#measure_select_button").attr(datavase);
        $("#save_measure_button").attr(datavase, vx);
    }
    vaseTransferBack = () => {
        var vx = $("#save_measure_button").attr(datavase);
        $("#measure_select_button").attr(datavase, vx);
    }
    // +++++++++++++++++ qr down ++++++++++++++++++++++++++++++++++++++++++++//
    addMsr = (succFunc = () => { }) => {
        var inps = $("#add_measure_form input");
        evtFrm('evt_cd_107', inps);
        var d = {
            "a": A_ADD_MEASURE,
            "frm": inps,
            "frmCbk": function () { return ""; },
            "r": addMeasureRSP,
            "l": "#add_measurePopUp_loading",
            "x": succFunc,
            "sc": () => {
                $(d.lds).css("display", "flex");
                disable($("#save_measure_button"));
            },
            "rc": () => {
                enable($("#save_measure_button"), DT);
            }
        };
        frmSND(d);
    }
    var addMeasureRSP = (r, succFunc) => {
        if (r.isSuccess) {
            $("#add_measurement_button").fadeOut(TS, function () {
                $("#manage_measurement_button").fadeIn(TS);
            });
            $("#measure_manager").html(r.results[QR_MEASURE_CONTENT]);
            vaseTransferBack();
            $("#save_measure_button").removeAttr(onclickattr);
            (!empty(succFunc)) ? eval(succFunc)() : null;
            var cbtn = getCloseButton($("#measure_adder"));
            $(cbtn).click();
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
    updateMsr = () => {
        var inps = $("#add_measure_form input");
        evtFrm('evt_cd_109', inps);
        var ds = {
            "a": A_UPDATE_MEASURE,
            "frm": inps,
            "frmCbk": function () { return ""; },
            "r": updateMsrRSP,
            "l": "#add_measurePopUp_loading",
            "sc": () => {
                displayFadeIn(ds.l);
                disable($("#save_measure_button"));
            },
            "rc": () => { 
                displayFadeOut(ds.l);
                enable($("#save_measure_button"), DT);
            }
        };
        frmSND(ds);
    }
    var updateMsrRSP = function (r) {
        addMeasureRSP(r);
    }
    getMsrAdder = function (msr_id, popFunc) {
        var selector = $("#mange_measure_window .cart-element-edit-button[data-measure_id='" + msr_id + "']");
        var param_json = $(selector).attr("data-measure");
        var param_map = json_decode(param_json);
        var param = mapToParam(param_map);
        ds = {
            "nbToWrapper": 5,
            "d": param,
            "a": QR_GET_MEASURE_ADDER,
            "r": getMsrAdderRSP,
            "l": "#measurePopUp_loading",
            "x": popFunc,
            "sc": () => {
                displayFadeIn(ds.l);
            },
            "rc": () => {
                displayFadeOut(ds.l);
            }
        };
        SND(ds);
    }
    var getMsrAdderRSP = function (r, popFunc) {
        if (r.isSuccess) {
            $("#measure_adder").html(r.results[QR_GET_MEASURE_ADDER]);
            var btn = $("#save_measure_button");
            disable(btn);
            reactivate_AnimateInput_Elements();
            reactivate_ChangeInputUnit_Elements();
            reactivate_AnableMsrBtn_QR();
            eval(popFunc)();
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    /*—————————————————— MEASURE ADDER UP ———————————————————————————————————*/
    /*—————————————————— BOX MANAGER DOWN ———————————————————————————————————*/
    getBoxMngr = (conf, bxid) => {
        var params = mapToParam({ [A_GET_BX_MNGR]: conf, [KEY_BOX_ID]: bxid });
        var d = {
            "a": A_GET_BX_MNGR,
            "d": params,
            "r": getBoxMngrRSP,
            "l": "#box_manager_loading",
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
        // var cbtnx = $(popx).find("." + closebtnCls);
        var cbtnx = getCloseButton(popx);
        var bxid = $(sbtnx).attr(databoxid);
        var before = getFunc(databefore, sbtnx);
        var after = getFunc(dataafter, sbtnx);
        var d = {
            "a": A_ADD_BOX,
            "d": param,
            "r": addBoxRSP,
            "l": "#box_pricing_loading",
            "x": { "cbtnx": cbtnx, "bxid": bxid },
            "sc": () => { eval(before)(); displayFlexOn(d.l) },
            "rc": () => { eval(after)(); displayFlexOff(d.l) }
        };
        SND(d);
    }
    var addBoxRSP = (r, d) => {
        if (r.isSuccess) {
            // $("#box_manager_window .pop_up-content-block-inner").html(r.results[A_ADD_BOX]);
            getBoxMngr(CONF_ADD_BXPROD, d.bxid);
            $(d.cbtnx).click();
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    removeBox = (bxid, x) => {
        if (popAsk(ALERT_DELETE_BOX)) {
            var o = { [KEY_BOX_ID]: bxid };
            var p = mapToParam(o);
            evt('evt_cd_57', json_encode(o));
            var d = {
                "a": A_DELETE_BOX,
                "d": p,
                "r": removeBoxRSP,
                "l": ".basket_pop_loading",
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
            basketUpdateDatas(r);
            // getBasketPop();
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        } else if (r.errors[ALERT_DELETE_BOX] != null && r.errors[ALERT_DELETE_BOX] != "") {
            popAlert(r.errors[ALERT_DELETE_BOX].message);
        }
    }
    addBoxProduct = (sbtnx, popx) => {
        var frm = $("#form_check_prod_stock input");
        var x = $(sbtnx).attr(datatarget);
        var bxid = $(x).attr(submitdata);
        var param = mapToParam({ [KEY_BOX_ID]: bxid, [INPUT_PROD_ID]: prodID });
        var cbtnx = $(popx).find("." + closebtnCls);
        var j = json_encode(paramToObj($(frm).serialize() + "&" + param));
        evt('evt_cd_84', j);
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
            switchCloseNext($("#box_manager_window"), $("#basket_pop"), getBasketPop);
            handleFbPxl(r);
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        } else if (r.errors[A_ADD_BXPROD] != null && r.errors[A_ADD_BXPROD] != "") {
            popAlert(r.errors[A_ADD_BXPROD].message);
        }
    }
    /*—————————————————— PRICING MANAGER UP —————————————————————————————————*/
    /*—————————————————— BASKET MANAGER DOWN ————————————————————————————————*/
    basketUpdateData = (r, d, k) => {
        var x = $("[" + basketdata + "='" + d + "']");
        var v = r.results[k];
        fadeValue(x, v);
    }
    basketUpdateDatas = (r) => {
        if (r.isSuccess) {

            basketUpdateData(r, basketsumprods, KEY_SUM_PRODS);

            var ttx = $("[" + basketdata + "='" + baskettotal + "']");
            var ttv = r.results[KEY_TOTAL];
            fadeValue(ttx, ttv);

            var sbtx = $("[" + basketdata + "='" + basketsubtotal + "']");
            var sbtv = r.results[KEY_SUBTOTAL];
            fadeValue(sbtx, sbtv);

            var shipx = $("[" + basketdata + "='" + basketshipping + "']");
            var shipv = r.results[KEY_SHIPPING];
            fadeValue(shipx, shipv);

            var qtyx = $("[" + basketdata + "='" + basketquantity + "']");
            var qtyv = r.results[KEY_BSKT_QUANTITY];
            fadeValue(qtyx, qtyv);

            var dlvrx = $("[" + basketdata + "='" + basketdelivery + "']");
            var dlvrv = r.results[KEY_DELIVERY];
            fadeValue(dlvrx, dlvrv);

            var proddiscx = $("[" + basketdata + "='" + basketproddiscount + "']");
            var proddiscdadx = $(proddiscx).attr(dadx);
            if (KEY_SUB_DISC in r.results) {
                fadeValue(proddiscx, r.results[KEY_SUB_DISC]);
                $(proddiscdadx).slideDown(TS);
            } else {
                $(proddiscdadx).slideUp(TS);
            };

            var shipdiscx = $("[" + basketdata + "='" + basketshipdiscount + "']");
            var shipdiscdadx = $(shipdiscx).attr(dadx);
            if (KEY_SHIP_DISC in r.results) {
                fadeValue(shipdiscx, r.results[KEY_SHIP_DISC]);
                $(shipdiscdadx).slideDown(TS);
            } else {
                $(shipdiscdadx).slideUp(TS);
            };

            var freeshipx = $("[" + basketdata + "='" + basketfreeshipping + "']");
            var freeshipdadx = $(freeshipx).attr(dadx);
            if (KEY_FREE_SHIPPING in r.results) {
                fadeValue(freeshipx, r.results[KEY_FREE_SHIPPING]);
                $(freeshipdadx).slideDown(TS);
            } else {
                $(freeshipdadx).slideUp(TS);
            };
        }
    }
    setMoveBoxProduct = (btnx, bxid) => {
        var sbtn = $("#sumbit_box_manager");
        var sfunc = $(sbtn).attr(onclickattr);
        $(sbtn).attr(dataonclick, sfunc);

        var func = $(btnx).attr(dataonclick);
        disable(sbtn);
        $(sbtn).attr(onclickattr, func);

        var cbtn = getCloseButton("#box_manager_window");
        var cf = "unsetMoveBoxProduct()";
        pushFunc(cbtn, cf);

        $("#box_pricing_window").find("." + submitCls).attr(databoxid, bxid);
    }
    unsetMoveBoxProduct = () => {
        var sbtn = $("#sumbit_box_manager");
        disable(sbtn);
        var sfunc = $(sbtn).attr(dataonclick);
        $(sbtn).attr(onclickattr, sfunc);
        $(sbtn).removeAttr(dataonclick);
        $("#box_pricing_window").find("." + submitCls).removeAttr(databoxid);
    }
    getBasketPop = () => {
        var d = {
            "a": A_GET_BSKT_POP,
            "d": null,
            "r": getBasketPopRSP,
            "l": ".basket_pop_loading, .loading-img-wrap",
            // "x": cbtnx,
            "sc": () => { displayFlexOn(d.l) },
            "rc": () => { displayFlexOff(d.l) }
        };
        SND(d);
    }
    var getBasketPopRSP = (r) => {
        if (r.isSuccess) {
            $("#basket_pop .pop_up-content-block-inner").html(r.results[A_GET_BSKT_POP]);
            $("#shopping_bag").html(r.results[KEY_CART_FILE]);
            basketUpdateDatas(r);
        } else if (r.errors[FAT_ERR] != null && r.errors[FAT_ERR] != "") {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    moveBoxProduct = (bxid, pid, seq) => {
        var targetx = $("#sumbit_box_manager").attr(datatarget);
        var newbxid = $(targetx).attr(submitdata);
        var o = {
            [KEY_BOX_ID]: bxid,
            [KEY_NEW_BOX_ID]: newbxid,
            [KEY_PROD_ID]: pid,
            [KEY_SEQUENCE]: seq,
        }
        var params = mapToParam(o);
        evt('evt_cd_66', json_encode(o));
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
    var moveBoxProductRSP = (r) => {
        if (r.isSuccess) {
            getBasketPop();
            unsetMoveBoxProduct();
            var cbtn = getCloseButton("#box_manager_window");
            $(cbtn).click();
        } else if (!empty(r.errors[FAT_ERR])) {
            popAlert(r.errors[FAT_ERR].message);
        } else if (!empty(r.errors[A_MV_BXPROD])) {
            popAlert(r.errors[A_MV_BXPROD].message);
        }
    }
    removeBoxProduct = (bxid, pid, seq, bxelx, elx) => {
        if (popAsk(ALERT_DLT_BXPROD)) {
            var o = {
                [KEY_BOX_ID]: bxid,
                [KEY_PROD_ID]: pid,
                [KEY_SEQUENCE]: seq,
            }
            var params = mapToParam(o);
            evt('evt_cd_61', json_encode(o));
            var d = {
                "a": A_DLT_BXPROD,
                "d": params,
                "r": removeBoxProductRSP,
                // "l": "#box_manager_loading",
                "x": { "bxelx": bxelx, "elx": elx },
                "sc": () => { },
                "rc": () => { }
            };
            SND(d);
        }
    }
    var removeBoxProductRSP = (r, d) => {
        if (r.isSuccess) {
            basketUpdateDatas(r);
            var x = $(d.bxelx).find("[" + basketdata + "=" + basketboxrate + "]");
            fadeValue(x, r.results[KEY_BOX_ID]);
            removeAnim(d.elx);
        } else if (!empty(r.errors[FAT_ERR])) {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    /*—————————————————— BASKET MANAGER UP ——————————————————————————————————*/
    /*—————————————————— SIZE EDITOR DOWN ———————————————————————————————————*/
    getSizeEditor = (bxid, pid, seq, popFunc) => {
        var map = {
            [KEY_BOX_ID]: bxid,
            [KEY_PROD_ID]: pid,
            [KEY_SEQUENCE]: seq,
        }
        var params = mapToParam(map);
        var d = {
            "a": A_GET_EDT_POP,
            "d": params,
            "r": getSizeEditorRSP,
            "l": ".basket_pop_loading, .loading-img-wrap",
            "x": popFunc,
            "sc": () => { displayFlexOn(d.l) },
            "rc": () => { displayFlexOn(d.l) }
        };
        SND(d);
    }
    var getSizeEditorRSP = (r, popFunc) => {
        if (r.isSuccess) {
            var y = createNone(r.results[A_GET_EDT_POP]);
            $("#size_editor_pop").html(y);
            eval(popFunc)();
            displayFadeIn(y);
        } else if (!empty(r.errors[FAT_ERR])) {
            popAlert(r.errors[FAT_ERR].message);
        }
    }
    updateBoxProduct = () => {
        var frmx = "#form_edit_prod_size";
        var frm = $(frmx).find("input");
        evtFrm('evt_cd_80', frm);
        var d = {
            "frm": frm,
            "a": A_EDT_BXPROD,
            "frmCbk": () => { },
            "r": updateBoxProductRSP,
            "l": "#size_form_pop_loading",
            "x": { "frmx": frmx },
            "sc": () => { displayFlexOn(d.l, TS / 10); },
            "rc": () => { displayFlexOff(d.l, TS); }
        };
        frmSND(d);
    }
    var updateBoxProductRSP = (r, x) => {
        if (r.isSuccess) {
            getBasketPop();
            var cbtn = getCloseButton("#size_editor_pop");
            $(cbtn).click();
        } else {
            handleErr(r, x.frmx);
        }
    }
    /*—————————————————— SIZE EDITOR UP —————————————————————————————————————*/

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