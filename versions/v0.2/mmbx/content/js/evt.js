(function () {
    dataevtopen = "data-evtopen";
    dataevtclose = "data-evtclose";
    dataevtj = "data-evtj";
    dataevtcd = "data-evtcd";
    evt = (e, j) => {
        var map = { [EVT_K]: e, [EVT_D]: j };
        var p = mapToParam(map);
        var d = {
            "a": QR_EVENT,
            "d": p,
            "r": () => { },
            "l": "",
            "sc": () => { },
            "rc": () => { }
        };
        SND(d);
    }
    evtOpen = (x) => {
        var evtcd = $(x).attr(dataevtopen);
        var j = $(x).attr(dataevtj);
        (!empty(evtcd)) ? evt(evtcd, j) : null;
    }
    evtClose = (x) => {
        var evtcd = $(x).attr(dataevtclose);
        var j = $(x).attr(dataevtj);
        (!empty(evtcd)) ? evt(evtcd, j) : null;
    }
    evtInp = (x, evtcd) => {
        var n = $(x).attr("name");
        var v = $(x).val();
        var j = json_encode({ [n]: v });
        evt(evtcd, j);
    }
    evtCheck = (x, evtcd) => {
        var n = $(x).attr("name");
        var v = ($(x).is(":checked")) ? $(x).val() : null;
        var j = json_encode({ [n]: v });
        evt(evtcd, j);

    }
    evtFrm = (evtcd, inps) => {
        var j = json_encode(paramToObj($(inps).serialize()));
        evt(evtcd, j);
    }
    retreiveEvt = (x) => {
        var evtcd = $(x).attr(dataevtcd);
        var j = $(x).attr(dataevtj);
        (!empty(evtcd)) ? evt(evtcd, j) : null;
    }
    evtTuto = (i, t, e, j) => {
        var map = { [TUTO_ID_K]: i, [TUTO_TYPE_K]: t, [EVT_K]: e, [EVT_D]: j };
        var p = mapToParam(map);
        var d = {
            "a": QR_EVENT_TT,
            "d": p,
            "r": () => { },
            "l": "",
            "sc": () => { },
            "rc": () => { }
        };
        SND(d);
    }
    /*————————————————————————— FB PXL DOWN —————————————————————————————————*/
    fbpxl = (e, j = null) => {
        var map = (empty(j)) ? { [KEY_FB_PXL]: e } : { [KEY_FB_PXL]: e, [KEY_FB_PXL_DT]: j };
        var p = mapToParam(map);
        var d = {
            "a": QR_FBPXL,
            "d": p,
            "r": fbpxlRSP,
            "l": "",
            "sc": () => { },
            "rc": () => { }
        };
        SND(d);
    }
    fbpxlRSP = (r) => {
        if (r.isSuccess) { handleFbPxl(r) }
    }
    /*————————————————————————— FB PXL UP ———————————————————————————————————*/
    scrollRate = () => {
        var pH = (parseInt($("body").height()) + $("body").offset().top);
        var ofs = window.pageYOffset;
        var mxOfs = ofs + window.innerHeight;
        if (ofs <= 0) {
            s = 0;
        } else {
            s = mxOfs
        }
        var r = (s / pH * 100).toFixed(2);
        return r;
    }
    $(document).ready(function () {
        var isS;
        window.addEventListener('scroll', (event) => {
            window.clearTimeout(isS);
            isS = setTimeout(() => {
                var r = scrollRate();
                var d = { [EVT_SCROLL]: r };
                var j = json_encode(d);
                evt("evt_cd_0", j);
                console.log(d);
            }, 1000);
            ((typeof lp != "undefined") && (!empty(lp))) ? lp() : null;
        }, false);

    });
}).call(this);