(() => {
    // ++++ data- down ++++
    const dadx = "data-dadx";
    const brotherx = "data-brotherx";
    const flagx = "data-flagx";
    const submitbtnx = "data-sbtnx";
    const datatarget = "data-datatarget";
    const submitdata = "data-submitdata";
    // ++++ class down ++++
    const selected = "popup-selected";
    disableCls = "standard-button-desabled";
    // ++++ shortcut down ++++
    getTag = (x) => {
        return $(x).prop("tagName").toLocaleLowerCase();
    }
    enable = function (x) {
        $(x).removeClass(disableCls);
        $(x).attr("disabled", false);
    }

    disable = function (x) {
        $(x).addClass(disableCls);
        $(x).attr("disabled", true);
    }

    select = (launchx, cb = () => { }) => {
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
        cb();
    }

    selectBrand = (sbtnx) => {
        var x = $(sbtnx).attr(datatarget);
        var brandDatas = json_decode($(x).attr(submitdata));
        var param = mapToParam(brandDatas);
        //build
        var datasSND = {
            "a": A_SELECT_BRAND,
            "d": param,
            "r": selectBrandRSP,
            "l": "#brandPopUp_loading",
            // "x": btnx,
            "sc": () => {
                $("#brandPopUp_loading").css("display", "flex");
                $("#add_measure_window .brand_reference-content").css("opacity", 0);
                disable(sbtnx);
            },
            "rc": cbkRSP = () => {
                $("#brandPopUp_loading").css("display", "flex");
                $("#add_measure_window .brand_reference-content").css("opacity", 1);
                enable(sbtnx);
            }
        };
        SND(datasSND);
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

    $(document).ready(() => {

    })
}).call(this)