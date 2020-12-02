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
            // "x": cbtnx,
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
        console.log("x", x);
        var evtcd = $(x).attr(dataevtcd);
        var j = $(x).attr(dataevtj);
        (!empty(evtcd)) ? evt(evtcd, j) : null;
    }
    $(document).ready(function () {
        var isS;
        window.addEventListener('scroll', (event) => {
            window.clearTimeout(isS);
            isS = setTimeout(() => {
                var pH = (parseInt($("body").height()) + $("body").offset().top);
                var ofs = window.pageYOffset;
                var mxOfs = window.pageYOffset + window.innerHeight;
                if (ofs <= 0) {
                    s = 0;
                } else if (mxOfs < pH) {
                    s = window.pageYOffset + (window.innerHeight / 2);
                } else {
                    s = mxOfs
                }
                var r = (s / pH * 100).toFixed(2);
                var d = { [EVT_SCROLL]: r };
                var j = json_encode(d);
                evt("evt_cd_0", j);
                console.log(d);
            }, 1000);
        }, false);

    });
}).call(this);