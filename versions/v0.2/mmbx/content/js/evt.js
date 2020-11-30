(function(){
    evt = (e, j) => {
        var map = { [EVT_K]: e, [EVT_D]: j};
        var p = mapToParam(map);
        var d = {
            "a": QR_EVENT,
            "d": p,
            "r": ()=>{},
            "l": "",
            // "x": cbtnx,
            "sc": () => {},
            "rc": () => {}
        };
        SND(d);
    }
    $(document).ready(function () {
        
    });
}).call(this);