(function () {
    dataevtopen = "data-evtopen";
    dataevtclose = "data-evtclose";
    dataevtj = "data-evtj";
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
        evt(evtcd, j);
    }
    evtClose = (x) => {
        var evtcd = $(x).attr(dataevtclose);
        var j = $(x).attr(dataevtj);
        evt(evtcd, j);
    }
    $(document).ready(function () {
        var isS;
        window.addEventListener('scroll', function (event) {
            window.clearTimeout(isS);
            isS = setTimeout(function () {
                var s = ($("html").scrollTop() / ($("html").height() - window.innerHeight) * 100).toFixed(2);
                if (s <= 0) {
                    var s = ($("html").scrollTop() / ($("html").height() - window.innerHeight) * 100).toFixed(2);
                }
                var d = { [EVT_SCROLL]: s };
                var j = json_encode(d);
                evt("evt_cd_0", j);
            }, 1000);
        }, false);

    });
}).call(this);