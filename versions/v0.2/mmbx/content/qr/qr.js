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
    var addErr = function (s, err) {
        $(s).text(err);
        $(s).slideDown(TS);
    }
    //———————————————————————————— SHORTCUT UP ————————————————————————————————————————————————————
    //—————————————————————————————————————————————————————————————————————————————————————————————

    // const jx = function (jxd, jxf, f, lds, cbkSND = function () { }, cbkRSP = function () { }) {
    //     $(lds).fadeIn(TS, cbkSND());
    //     $.ajax({
    //         type: 'POST',
    //         url: jxf,
    //         data: jxd,
    //         dataType: 'json',
    //         success: function (r) {
    //             $(lds).fadeOut(TS, cbkRSP());
    //             f(r);
    //         }
    //     });
    // }

    // const jx = function (a, d, r, l, x = null, sc = () => { }, rc = () => { }) {
    //     $(l).fadeIn(TS, sc());
    //     $.ajax({
    //         type: 'POST',
    //         url: WR + a + "?" + LANG,
    //         data: d,
    //         dataType: 'json',
    //         success: function (j) {
    //             $(l).fadeOut(TS, rc());
    //             console.log("response: ", j);
    //             r(j, x);
    //         }
    //     });
    // }

    // /**
    //  * var datas = {
    //  *      "qr" : QR_FILTER,
    //  *      "inputSelector" : "#grid_filter input",
    //  *      "frmCbk" : getCol,
    //  *      "f" : filterRSP,
    //  *      "lds" : "#prodGrid_loading",
    //  *      "cbkSND" : function () { },
    //  *      "cbkRSP" : function () { }
    //  * }
    //  */
    // frmSND = function (datas) {
    //     var param = $(datas.frm).serialize();
    //     if (datas.frmCbk() != null) {
    //         param += datas.frmCbk();
    //     }

    //     var datasSND = {
    //         "a": datas.a,
    //         // "qr": datas.qr,
    //         "d": param,
    //         "r": datas.r,
    //         "l": datas.l,
    //         "x": datas.x,
    //         "sc": datas.sc,
    //         "rc": datas.rc
    //     };
    //     SND(datasSND);
    // }

    // /**
    //  * var datas = {
    //  *     "qr": A_DELETE_MEASURE,
    //  *     "param": param,
    //  *     "f": removeMsrRSP,
    //  *     "lds": "#measurePopUp_loading",
    //  *     "cbkSND": msrMangerLoading_on,
    //  *     "cbkRSP": msrMangerLoading_off
    //  * };
    //  */
    // const SND = function (datas) {
    //     var a = datas.a;
    //     var d = datas.d;
    //     var r = datas.r;
    //     var l = datas.l;
    //     var x = datas.x;
    //     var sc = datas.sc;
    //     var rc = datas.rc;
    //     console.log("send: ", d);
    //     console.log("to: ", WR + a + "?" + LANG);
    //     jx(a, d, r, l, x, sc, rc);
    // }

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

    /**
     * datas = [
     *  "nbToElementContainer" => 1,
     *  "shadowSupportClass" => "brand_reference-grid-img-block",
     *  "shadowClass" => "selected_element_shadow",
     *  "dataAttrName4selectedElement" => "data-selected_brand",
     *  "beginSequenceStr" => "brand_",
     *  "submitBtnId" => "brand_validate_button",
     *  "btnDesableClass" => "standard-button-desabled",
     *  "btnDataAttrName_targerClass" => "data-brand_class",
     *  "goToelementWrapper" => 0,
     * ]
     */
    // var selectPopUpElement = function (selector, datas) {
    //     //cleaning
    //     var selectorClass = $(selector).attr("class");
    //     var brandContainer = goToParentNode(selector, datas.nbToElementContainer);
    //     var elementWrapper = goToParentNode(selector, datas.goToelementWrapper);

    //     $(brandContainer).find("." + datas.shadowSupportClass).removeClass(datas.shadowClass);
    //     $(brandContainer).find("." + selectorClass).removeAttr(datas.dataAttrName4selectedElement);

    //     //adding
    //     var selectorId = datas.beginSequenceStr + randomInt(BNR);
    //     $(selector).attr(datas.dataAttrName4selectedElement, selectorId);
    //     $(elementWrapper).addClass(datas.shadowClass);

    //     //reffering
    //     var submitBtn = $("#" + datas.submitBtnId)[0];
    //     $(submitBtn).attr(datas.dataAttrName4selectedElement, selectorId);
    //     $(submitBtn).attr(datas.btnDataAttrName_targerClass, selectorClass);
    //     enable(submitBtn, datas.btnDesableClass);
    // }

    /**
     * datas = {
     *  "btnDataAttrName_targerClass" : "data-brand_class",
     *  "dataAttrName4selectedElement" : "data-selected_brand",
     *  "dataAttrName_4_dataToPost" : "data-brand",
     *  "qr" : A_SELECT_BRAND,
     *  "f" : selectBrandRSP,
     *  "lds" : "#brandPopUp_loading",
     *  "cbkSND" : function () { $(lds).css("display", "flex"); 
     *                          $("#add_measure_window .brand_reference-content").css("opacity", 0);
     *                        }
     *  "cbkRSP" : function () { $(lds).css("display", "flex"); }; 
     *                          $("#add_measure_window .brand_reference-content").css("opacity", 1);
     *                        }
     * }
     */
    // var submitPopUp = function (selector, datas) {
    //     //getting
    //     var brandwrapClass = $(selector).attr(datas.btnDataAttrName_targerClass);
    //     var brandwrapClassList = brandwrapClass.split(" ");
    //     var brandWrapSelector = brandwrapClassList[0];
    //     var brandwrapId = $(selector).attr(datas.dataAttrName4selectedElement);
    //     var brandwrap = $("." + brandWrapSelector + "[" + datas.dataAttrName4selectedElement + "='" + brandwrapId + "']");
    //     console.log($(brandwrap).attr(datas.dataAttrName_4_dataToPost));
    //     var brandDatas = json_decode($(brandwrap).attr(datas.dataAttrName_4_dataToPost));
    //     // var param = jQuery.param(brandDatas);
    //     var param = mapToParam(brandDatas);
    //     //build
    //     var datasSND = {
    //         "a": datas.a,
    //         "d": param,
    //         "r": datas.r,
    //         "l": datas.l,
    //         "sc": datas.cbkSND,
    //         "rc": datas.cbkRSP
    //     };
    //     SND(datasSND);
    // }

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

    var addMeasureRSP = function (r) {
        if (r.isSuccess) {
            $("#add_measurement_button").fadeOut(TS, function () {
                $("#manage_measurement_button").fadeIn(TS);
            });
            // $("#mange_measure_window .customize_measure-content").html(r.results[QR_MEASURE_CONTENT]);
            $("#measure_manager").html(r.results[QR_MEASURE_CONTENT]);
            measurePopUpBack();
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

    var removeAnimation = function (selector) {
        $(selector).css("overflow", "hidden");
        var h = $(selector).height();
        $(selector).height(h);
        $(selector).animate({ width: '0%' }, TS, function () {
            $(this).slideUp(TS, function () {
                $(this).remove();
            });
        });
    }

    var removeMsrRSP = function (r) {
        if (r.isSuccess) {
            var selector = $("#mange_measure_window .close_button-wrap[data-measure_id='" + r.results[MEASURE_ID_KEY] + "']");
            var wrapper = goToParentNode(selector, removeMsrDatas.nbToWrapper);
            removeAnimation(wrapper);
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

    var getMsrAdderRSP = function (r) {
        if (r.isSuccess) {
            // $("#add_measure_window .pop_up-content-block .customize_measure-content").html(r.results[QR_GET_MEASURE_ADDER]);
            $("#measure_adder").html(r.results[QR_GET_MEASURE_ADDER]);
            simpleSwitchToMsr();
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

    var updateMsrRSP = function (r) {
        addMeasureRSP(r);
    }
    var addProdRSP = function (r) {
        if (r.isSuccess) {
            displayPopUp("#box_manager_window");
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
        /*—————————————————— SIZE CUSTOMISER DOWN ———————————————————————————*/
        //—— BRAND DOWN ——//
        // $(".brand_reference-grid-img-block").click(function () {
        //     var datas = {
        //         "nbToElementContainer": 1,
        //         "shadowSupportClass": "brand_reference-grid-img-block",
        //         "shadowClass": "selected_element_shadow",
        //         "dataAttrName4selectedElement": "data-selected_brand",
        //         "beginSequenceStr": "brand_",
        //         "submitBtnId": "brand_validate_button",
        //         "btnDesableClass": "standard-button-desabled",
        //         "btnDataAttrName_targerClass": "data-brand_class",
        //         "goToelementWrapper": 0
        //     };
        //     selectPopUpElement(this, datas);
        // });
        // $("#brand_validate_button").click(function () {
        //     var datas = {
        //         "btnDataAttrName_targerClass": "data-brand_class",
        //         "dataAttrName4selectedElement": "data-selected_brand",
        //         "dataAttrName_4_dataToPost": "data-brand",
        //         "a": A_SELECT_BRAND,
        //         "r": selectBrandRSP,
        //         "l": "#brandPopUp_loading",
        //         "sc": function () {
        //             $(datas.lds).css("display", "flex");
        //             $("#add_measure_window .brand_reference-content").css("opacity", 0);
        //         },
        //         "rc": cbkRSP = function () {
        //             $(datas.lds).css("display", "flex");
        //             $("#add_measure_window .brand_reference-content").css("opacity", 1);
        //         }
        //     };
        //     submitPopUp(this, datas);
        // })
        //—— BRAND UP ——//
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
        saveMsr = function () {
            frmSND(saveMsrDts);
        }
        saveMsrDts = {
            "a": A_ADD_MEASURE,
            "frm": "#add_measure_form input",
            "frmCbk": function () { return ""; },
            "r": addMeasureRSP,
            "l": "#add_measurePopUp_loading",
            "sc": function () {
                $(saveMsrDts.lds).css("display", "flex");
            },
            "rc": function () { }
        };
        //—— ADD MEASUREMENT UP ————//
        //—— MANAGE MEASUREMENT DOWN ——//
        /*--focus down--*/
        // selectMeasurement = function (msr_id) {
        //     var datas = {
        //         "nbToElementContainer": 6,
        //         "shadowSupportClass": "cart-element-wrap",
        //         "shadowClass": "selected_element_shadow",
        //         "dataAttrName4selectedElement": "data-selected_measure",
        //         "beginSequenceStr": "measure_",
        //         "submitBtnId": "measure_select_button",
        //         "btnDesableClass": "standard-button-desabled",
        //         "btnDataAttrName_targerClass": "data-measure_class",
        //         "goToelementWrapper": 4
        //     };
        //     var selector = $(".manager-measure-property-set[data-measure_id='" + msr_id + "']");
        //     selectPopUpElement(selector, datas);
        // }
        /*--focus up--*/
        /*--submit focus down--*/
        // $("#measure_select_button").click(function () {
        //     var datas = {
        //         "btnDataAttrName_targerClass": "data-measure_class",
        //         "dataAttrName4selectedElement": "data-selected_measure",
        //         "dataAttrName_4_dataToPost": "data-measure",
        //         "a": A_SELECT_MEASURE,
        //         "r": selectMeasureRSP,
        //         "l": "#measurePopUp_loading",
        //         "sc": msrMangerLoading_on,
        //         "rc": msrMangerLoading_off
        //     };
        //     submitPopUp(this, datas);
        // });
        msrMangerLoading_on = function () {
            $("#measurePopUp_loading").css("display", "flex");
            $("#mange_measure_window .customize_measure-content").css("opacity", 0);
        }
        msrMangerLoading_off = function () {
            $("#measurePopUp_loading").css("display", "flex");
            $("#mange_measure_window .customize_measure-content").css("opacity", 1);
        }
        /*--submit focus up--*/
        /*--remove focus down--*/
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
        /*--remove focus up--*/
        /*-- open editor down--*/
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
        /*-- open editor up--*/
        /*-- submit editor down--*/
        updateMsr = function () {
            frmSND(updateMsrDts);
        }
        updateMsrDts = {
            "a": A_UPDATE_MEASURE,
            "frm": "#add_measure_form input",
            "frmCbk": function () { return ""; },
            "r": updateMsrRSP,
            "l": "#add_measurePopUp_loading",
            "sc": function () {
                $(updateMsrDts.lds).css("display", "flex");
            },
            "rc": function () { }
        };
        /*-- submit editor up--*/
        //—— MANAGE MEASUREMENT UP ——//
        /*—————————————————— SIZE CUSTOMISER UP —————————————————————————————*/
        /*—————————————————— ADD PRODUCT DOWN ———————————————————————————————*/
        /*———— sumbit sizes down ————*/
        $("#select_size_for_box").click(function (e) {
            e.preventDefault();
            var frm = $("#add_prod_form input");
            var datas = {
                "frm": frm,
                "frmCbk": function () {
                    return "&" + INPUT_PROD_ID + "=" + prodID;
                },
                "a": A_ADD_PROD,
                "r": addProdRSP,
                "l": "#add_prod_loading",
                "sc": addProdFlex_on,
                "rc": function () { }
            };
            frmSND(datas);
        });
        var addProdFlex_on = function () {
            $("#add_prod_loading").css("display", "flex");
        }
        // var btnFlex_off = function (l) {
        //     $(l).css("display", "");
        // }
        /*———— sumbit sizes up ———*/
        /*—————————————————— ADD PRODUCT UP —————————————————————————————————*/



    });
}).call(this);