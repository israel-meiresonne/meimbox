evtDeviceSize = () => {
    var d = {
        "height": window.innerHeight,
        "width": window.innerWidth
    };
    var j = json_encode(d);
    evt("evt_cd_1", j);
}
evtDeviceSize();