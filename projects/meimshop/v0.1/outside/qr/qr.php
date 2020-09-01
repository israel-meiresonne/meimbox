<?php
// error_reporting(-1);
// ini_set('display_errors', true); 

try {

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("../../oop/controller/Dependency.php");
    Dependency::requireControllerDependencies("../../");
    $query = GeneralCode::clean($_POST["qr"]);
    switch ($query) {
        case Search::QR_FILTER:
            $controller = new Controller();
            $response = $controller->getFilterPOSTSearch();
            break;
        case Size::QR_SELECT_BRAND:
            $controller = new Controller();
            $response = $controller->getBrandSticker();
            break;
        case Measure::QR_SELECT_MEASURE:
            $controller = new Controller();
            $response = $controller->getMeasureSticker();
            break;
        case Measure::QR_ADD_MEASURE:
            $controller = new Controller();
            $response = $controller->addMeasure();
            break;
        case Measure::QR_DELETE_MEASURE:
            $controller = new Controller();
            $response = $controller->deleteMeasure();
            break;
        case Measure::QR_GET_MEASURE_ADDER:
            $controller = new Controller();
            $response = $controller->getMeasureAdderContent();
            break;
        case Measure::QR_GET_EMPTY_MEASURE_ADDER:
            $controller = new Controller();
            $response = $controller->getMeasureAdderContentEmpty();
            break;
        case Measure::QR_UPDATE_MEASURE:
            $controller = new Controller();
            $response = $controller->updateMeasure();
            break;
    }
    if(!empty($response)){
        echo json_encode($response->getAttributs());
    } else {
        echo json_encode(null);
        // echo json_encode($_POST);
    }
    // echo json_encode($response);
    // echo json_encode($_POST);
    // echo"ok";
}
} catch (\Throwable $th) {
    echo $th;
}
