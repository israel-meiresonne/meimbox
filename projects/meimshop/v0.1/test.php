<?php
// error_reporting(-1);
// ini_set('display_errors', true); 

try {
    require_once "oop/controller/Dependency.php";
    Dependency::requireControllerDependencies("");
    // require_once "oop/model/users-management/Database_Connection.php";

    // list of time zone https://www.php.net/manual/en/timezones.php
    date_default_timezone_set('Europe/Paris');

    // $db = new Database();

    $controller = new Controller();
    // $controller->__toString();
    $dbMap = $controller->getDbMap();

    // $measure = new Measure($dbMap["usersMap"]["usersMeasures"][651853948740], $dbMap);
    // $unitA = $measure->getarm();
    // $unitB = $measure->getbust();
    // $a = [
    //     0 => $unitA,
    //     1 => $unitB,
    //     2 => $unitB
    // ];

    // $a = (array)$unitA;
    // Helper::printLabelValue('before', $a);
    // var_dump($a);
    // Helper::printLabelValue('before', array_keys($a));
    // Helper::printLabelValue('before', $a["MeasureUnitunitName"]);



} catch (\Throwable $th) {
    echo $th;
}
